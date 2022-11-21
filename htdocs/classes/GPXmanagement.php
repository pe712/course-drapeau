<?php

class GPX
{
    public $id;
    public $heure_dep;
    public $heure_arr;
    public $gps_dep;
    public $gps_arr;
    public $trinome_id;

    public static function uploadGPX_updateDB_multiple()
    {
        $file_post = $_FILES["traces"];
        $files = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i = 0; $i < $file_count; $i++) {
            foreach ($file_keys as $key) {
                $files[$i][$key] = $file_post[$key][$i];
            }
        }

        foreach ($files as $file) {
            if (!GPX::uploadGPX_updateDB($file))
                break;
        }
    }

    public static function uploadGPX_updateDB($file)
    {
        preg_match("/\d+/", $file['name'], $matches);
        if (count($matches) == 0) {
            $_SESSION["displayError"] = "le nom du fichier est incorrect, ce doit être trace15.gpx par exemple.";
        } else {
            $num = $matches[0];
            $dossier = "pages/Troncons/traces/";
            $name = "trace$num.gpx";

            $trace = new Upload(array("gpx", "GPX"), 3000000, $dossier);
            if ($trace->upload($name, $file)) {
                GPX::update_GPXStartStop_DB($dossier . $name, $num);
                return true;
            } else
                return false;
        }
    }

    public static function update_GPXStartStop_DB($file, $num)
    {
        $xml = simplexml_load_file($file);
        $pts = $xml->trk->trkseg->trkpt;
        $start = $pts[0];
        $stop = $pts[count($pts) - 1];
        $start_gps = number_format(floatval($start["lat"]), 5) . " " . number_format(floatval($start["lon"]), 5);
        $stop_gps = number_format(floatval($stop["lat"]), 5) . " " . number_format(floatval($stop["lon"]), 5);
        $start_gps = htmlspecialchars($start_gps);
        $stop_gps = htmlspecialchars($stop_gps);

        global $conn;
        $select = $conn->prepare("select * from tracesgpx where id=?");
        $select->execute(array($num));
        if ($select->rowCount() > 0) {
            $update = $conn->prepare("update tracesgpx set gps_dep=?, gps_arr=? where id=?");
            $update->execute(array($start_gps, $stop_gps, $num));
        } else {
            $insert = $conn->prepare("insert into tracesgpx (id, gps_dep, gps_arr) values (?,?,?)");
            $insert->execute(array($num, $start_gps, $stop_gps));
        }
    }

    public static function merge_GPX($folder)
    {
        global $conn;
        $select = $conn->query("select max(id) from tracesgpx");
        $n = $select->fetch()[0];
        $n = 3;
        $global_xml = simplexml_load_file($folder . "/en_tete.gpx");
        $global_pts = $global_xml->trk->trkseg;
        for ($i = 1; $i <= $n; $i++) {
            $filename = $folder . "/trace$i.gpx";
            $xml = simplexml_load_file($filename);
            $pts = $xml->trk->trkseg->trkpt;
            foreach ($pts as $pt) {
                GPX::addTrkpt($global_pts, $pt);
            }
        }
        $filename_global = $folder . "/trace_complete.gpx";
        $global_xml->asXML($filename_global);
    }

    private static function addTrkpt($global_pts, $input_trkpt){
        $trkpt = $global_pts->addChild("trkpt");
        $trkpt->addAttribute("lat", $input_trkpt["lat"]);
        $trkpt->addAttribute("lon", $input_trkpt["lon"]);
        $trkpt->addChild("ele", $input_trkpt->ele);
        $trkpt->addChild("time", $input_trkpt->time);
    }

    public static function removeGPX()
    {
        //cette fonction est toujours accédée depuis le dossier ajax
        $dossier = '../pages/Troncons/traces/trace';

        global $conn;
        $select = $conn->query("SELECT * from tracesgpx");
        $n = $select->rowCount();

        for ($i = 1; $i <= $n; $i++) {
            unlink($dossier . $i . ".gpx");
        }

        $delete = $conn->query("DELETE from tracesgpx");
        echo "traces GPX supprimées";
    }

    public static function calculHoraires()
    {
        global $conn;
        $select = $conn->query("SELECT contenu, item from content JOIN content_section ON content.Sid=content_section.id where page='Troncons' and section=1");
        $select->setFetchMode(PDO::FETCH_CLASS, 'Content');
        while ($horaire = $select->fetch()) {
            if ($horaire->item == 1)
                $hdep = $horaire->contenu;
            else
                $harr = $horaire->contenu;
        }
        $select = $conn->query("SELECT * from tracesgpx");
        $n = $select->rowCount();
        if ($n == 0) {
            echo "Il n'y aucune trace GPX pour le moment";
            return;
        }

        // GPX::calcul1($hdep, $harr, $n);
        GPX::calcul2($hdep);

        GPX::repartition_blocs($n);
    }

    private static function calcul2($hdep)
    {
        $segments = array(1, 4, 16, 25, 36, 45, 57, 65, 77);
        for ($i = 0; $i < sizeof($segments) - 2; $i += 2) {
            $hdep = GPX::update_jour_nuit($hdep, $segments[$i], $segments[$i + 1], $segments[$i + 2]);
        }
        $delta_jour = 65 * 60;
        GPX::update($hdep, $hdep + $delta_jour, 77);
        $hdep += $delta_jour;
        GPX::update($hdep, $hdep + $delta_jour, 78);
        echo "Les horaires des traces ont été mis à jour en fontion de l'heure de départ et d'arrivée";
    }

    private static function update_jour_nuit($hdep, $start, $end, $stop)
    {
        $delta_jour = 65 * 60;
        $delta_nuit = 75 * 60;
        for ($i = $start; $i < $end; $i++) {
            GPX::update($hdep, $hdep + $delta_jour, $i);
            $hdep += $delta_jour;
        }
        for ($i = $end; $i < $stop; $i++) {
            GPX::update($hdep, $hdep + $delta_nuit, $i);
            $hdep += $delta_nuit;
        }
        return $hdep;
    }

    private static function update($hdep, $harr, $id)
    {
        global $conn;
        $update = $conn->prepare("UPDATE tracesgpx set heure_dep=FROM_UNIXTIME(?), heure_arr=FROM_UNIXTIME(?) where id =?");
        $update->execute(array($hdep, $harr, $id));
    }

    private static function calcul1($hdep, $harr, $n)
    {
        $duration = $harr - $hdep;
        $delta = $duration / $n;
        $current_delta = 0;
        for ($i = 1; $i <= $n; $i++) {
            GPX::update($hdep + $current_delta, $hdep + $current_delta + $delta, $i);
            $current_delta += $delta;
        }
        echo "Les horaires des traces ont été mis à jour en fontion de l'heure de départ et d'arrivée";
    }

    private static function repartition_blocs($n_creneaux)
    {
        global $conn;
        $n_creneaux_groupes = $n_creneaux / 4;
        $G = 6; //groupes de deux trinomes = nombres de groupes dans chaque bloc
        $decallage_bloc = round($G * $G / $n_creneaux_groupes);
        $n_blocs = floor($n_creneaux_groupes / $G);
        for ($kbloc = 0; $kbloc < $n_blocs; $kbloc++) {
            for ($kgroupe = 0; $kgroupe < $G; $kgroupe++) {
                $firstid_groupe = ($kgroupe + $decallage_bloc * $kbloc) % $G;
                $firstid = $kbloc * $G * 4 + $kgroupe * 4 + 1;
                for ($i = 0; $i < 4; $i++) {
                    $groupe_courant = $firstid_groupe * 2 + ($i % 2) + 1;
                    $id = $firstid + $i;
                    $update = $conn->query("update tracesgpx set trinome_id=$groupe_courant where id=$id");
                }
            }
        }
    }


    public static function getGPXdata($trinome = null)
    {
        global $conn;
        if ($trinome == null) {
            $select = $conn->prepare("SELECT id, UNIX_TIMESTAMP(heure_dep) as heure_dep, UNIX_TIMESTAMP(heure_arr) as heure_arr,gps_dep, gps_arr, trinome_id FROM tracesgpx");
        } else {
            $select = $conn->prepare("SELECT id, UNIX_TIMESTAMP(heure_dep) as heure_dep, UNIX_TIMESTAMP(heure_arr) as heure_arr,gps_dep, gps_arr, trinome_id FROM tracesgpx where trinome_id=$trinome");
        }
        $select->setFetchMode(PDO::FETCH_CLASS, 'GPX');
        $select->execute();
        return $select;
    }
}
