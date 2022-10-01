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
        $update = $conn->prepare("insert into tracesGPX (id, gps_dep, gps_arr) values (?,?,?)");
        $update->execute(array($num, $start_gps, $stop_gps));
    }
}
