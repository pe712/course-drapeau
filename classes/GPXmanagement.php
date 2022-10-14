<?php

class GPX
{
    public $id;
    public $h_dep;
    public $h_arr;
    public $gps_dep;
    public $gps_arr;

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
            GPX::uploadGPX_updateDB($file);
        }
    }

    public static function uploadGPX_updateDB($file)
    {
        $finalUrl = "index.php?page=Admin&pageModif=Acceuil&section=3";
        preg_match("/\d+/", $file['name'], $matches);
        if (count($matches) == 0) {
            $_SESSION["displayError"] = "le nom du fichier est incorrect, ce doit être trace15.gpx par exemple.";
        } else {
            $num = $matches[0];
            $dossier = "pages/troncons/";
            $name = "trace$num.gpx";

            $trace = new Upload(array(".gpx", ".GPX"), 3000000, $dossier, $finalUrl);
            $trace->upload($name, $file);

            GPX::update_GPXStartStop_DB($dossier . $name, $num);
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

        global $conn;
        $select = $conn->prepare("select * from tracesGPX where id=?");
        $select->execute(array($num));
        if ($select->rowCount() > 0) {
            $update = $conn->prepare("update tracesGPX set gps_dep=?, gps_arr=? where id=?");
            $update->execute(array($start_gps, $stop_gps, $num));
        } else {
            $insert = $conn->prepare("insert into tracesGPX (id, gps_dep, gps_arr) values (?,?,?)");
            $insert->execute(array($num, $start_gps, $stop_gps));
        }
    }

    public static function removeGPX()
    {
        //cette fonction est toujours accédée depuis le dossier ajax
        $dossier = '../pages/troncons/trace';

        global $conn;
        $select = $conn->query("SELECT * from tracesGPX");
        $n = $select->rowCount();

        for ($i = 1; $i <= $n; $i++) {
            unlink($dossier . $i . ".gpx");
        }

        $delete = $conn->query("DELETE from tracesGPX");
        echo "traces GPX supprimées";
    }

    public static function calculHoraires()
    {
        global $conn;
        $select = $conn->query("SELECT contenu, item from content where page='Troncons' and section=1");
        $select->setFetchMode(PDO::FETCH_CLASS, 'Content');
        while ($horaire = $select->fetch()) {
            if ($horaire->item== 1)
                $hdep = $horaire->contenu;
            else
                $harr = $horaire->contenu;
        }
        $duration = $harr - $hdep;
        $select = $conn->query("SELECT * from tracesGPX");
        $n = $select->rowCount();
        if ($n == 0)
            echo "Il n'y aucune trace GPX pour le moment";
        else {
            $delta = $duration / $n;
            $current_delta = 0;
            for ($i = 1; $i <= $n; $i++) {
                $update = $conn->prepare("UPDATE tracesGPX set heure_dep=FROM_UNIXTIME(?), heure_arr=FROM_UNIXTIME(?) where id =?");
                $update->execute(array($hdep + $current_delta, $hdep + $current_delta + $delta, $i));
                $current_delta += $delta;
            }
            echo "Les horaires des traces ont été mis à jour en fontion de l'heure de départ et d'arrivée";
        }
    }
}
