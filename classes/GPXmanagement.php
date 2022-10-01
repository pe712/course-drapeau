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
        preg_match("/\d+/",$file['name'], $matches);
        if (count($matches) == 0) {
            $_SESSION["displayError"] = "le nom du fichier est incorrect, ce doit être trace15.gpx par exemple.";
        } else {
            $num = $matches[0];
            $dossier = "pages/troncons/";
            $name = "trace$num.gpx";

            require_once("classes/upload.php");
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
        $start_gps = $start["lat"] . " " . $start["lon"];
        $stop_gps = $stop["lat"] . " " . $stop["lon"];

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

    public static function removeGPX(){
        $dossier = 'pages/troncons/trace';
        
        global $conn;
        $select = $conn->query("SELECT * from tracesGPX");
        $n = $select->rowCount();

        for ($i=1; $i <= $n; $i++) { 
            unlink( $dossier.$i.".gpx" );
        }

        $delete = $conn->query("DELETE from tracesGPX");
    }
}
