<?php

class GPX
{
    public $id;
    public $h_dep;
    public $h_arr;
    public $gps_dep;
    public $gps_arr;

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
        if ($select->rowCount()>0){
            $update = $conn->prepare("update tracesGPX set gps_dep=?, gps_arr=? where id=?");
            $update->execute(array($start_gps, $stop_gps, $num));
        }
        else {
            $insert = $conn->prepare("insert into tracesGPX (id, gps_dep, gps_arr) values (?,?,?)");
            $insert->execute(array($num, $start_gps, $stop_gps));
        }
        
    }
}
