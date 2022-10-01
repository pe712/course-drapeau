<?php
if (array_key_exists("dlnum", $_GET)) {
    $num = $_GET["dlnum"];
    $file = "pages/troncons/trace$num.gpx";
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        flush(); // Flush system output buffer
        readfile($filepath);
        die();
    }
}
?>

<div class="btn-group adminView" role="group" aria-label="Basic radio toggle button group">
    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" onclick="changeView('map', 'tronconsListe')" checked>
    <label class="btn btn-outline-primary" for="btnradio1">Liste</label>

    <input type="radio" class="btn-check" name="btnradio" id="btnradio2" onclick="changeView('tronconsListe', 'map'); add_gpx('pages/troncons/trace5.gpx')">
    <label class="btn btn-outline-primary" for="btnradio2">Visualisation</label>
</div>



<div id="map"></div>
<script src="../scripts/map.js"></script>
<script>
</script>


<div id=tronconsListe>
    <table class="table table-striped table-hover">
        <tr>
            <th>Numéro troncon</th>
            <th>Heure de départ</th>
            <th>Point GPS de départ</th>
            <th>Heure arrivée</th>
            <th>Point GPS arrivée</th>
            <th>Télécharger la trace</th>
        </tr>
        <?php
        $troncons = array(
            array(
                "num" => "Admin",
                "hdep" => "14",
                "pdep" => "14.54.5",
                "harr" => "15",
                "parr" => ".54.54827",
            ),
        );
        foreach ($troncons as $tronc) {
            extract($tronc);
            echo <<<FIN
        <td>$num</td>
        <td>$hdep </td>
        <td><a id="pdep$num" href=# onclick="copier('pdep$num', 'Point GPS copié')">$pdep</td>
        <td>$harr</td>
        <td><a id="pdep$num" href=# onclick="copier('pdep$num', 'Point GPS copié')">$parr</td>
        <td><a href="pages/troncons/trace1.gpx" download>Télécharger</button></td>
        FIN;
        }
        ?>
    </table>
    <div id="cs-popup-area"></div>
</div>