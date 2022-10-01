<?php
class Content
{
    public $page;
    public $section;
    public $sous_section;
    public $contenu;
    public $description;

    public function __construct(
        $page = null,
        $section = null,
        $sous_section = null,
        $contenu = null,
        $description = null
    ) {
        $this->page = $page;
        $this->section = $section;
        $this->sous_section = $sous_section;
        $this->contenu = $contenu;
        $this->description = $description;
    }

    public function update_db()
    {
        global $conn;
        $update = $conn->prepare("update content set contenu=? WHERE page=? and section=? and sous_section=?");
        $update->execute(array($this->contenu, $this->page, $this->section, $this->sous_section));
    }
}

class GPX
{
    public static function update_GPXStartStop_DB($file, $num)
    {
        $xml = simplexml_load_file($file);
        $pts = $xml->trk->trkseg->trkpt;
        $start = $pts[0];
        $stop = $pts[count($pts) - 1];
        $start_gps = $start["lat"] . " " . $start["lon"];
        $stop_gps = $stop["lat"] . " " . $stop["lon"];

        global $conn;
        $update = $conn->prepare("insert into tracesGPS (id, GPS_dep, GPS_arr) values (?,?,?)");
        $update->execute(array($num, $start_gps, $stop_gps));
    }
}
