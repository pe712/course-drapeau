<div class="btn-group adminView" role="group" aria-label="Basic radio toggle button group">
    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" onclick="changeView('map', 'tronconsListe')" checked>
    <label class="btn btn-outline-primary" for="btnradio1">Liste</label>

    <input type="radio" class="btn-check" name="btnradio" id="btnradio2" onclick="changeView('tronconsListe', 'map'); add_gpx('pages/troncons/trace_complete.gpx', 0)">
    <label class="btn btn-outline-primary" for="btnradio2">Visualisation parcours complet</label>
</div>



<div id="map"></div>



<div id=tronconsListe>
    <table id="table" class="table table-striped table-hover">
        <tr>
            <th>Numéro troncon</th>
            <th>Heure de départ</th>
            <th>Point GPS de départ</th>
            <th>Heure arrivée</th>
            <th>Point GPS arrivée</th>
            <th>Voir sur la carte</th>
            <th>Télécharger la trace</th>
        </tr>
        <?php
        require("classes/GPXmanagement.php");
        $select = $conn->prepare("SELECT id, UNIX_TIMESTAMP(heure_dep) as heure_dep, UNIX_TIMESTAMP(heure_arr) as heure_arr,gps_dep, gps_arr FROM tracesGPX");
        $select->setFetchMode(PDO::FETCH_CLASS, 'GPX');
        $select->execute();
        while ($trace = $select->fetch()) {
            $date_dep = new DateTime();
            $date_arr = new DateTime();
            $date_dep->setTimestamp($trace->heure_dep);
            $date_arr->setTimestamp($trace->heure_arr);
            $date_dep = date_format($date_dep, "l H:i");
            $date_arr = date_format($date_arr, "l H:i");
            echo <<<FIN
        <tr>
            <td>$trace->id</td>
            <td>$date_dep</td>
            <td><a id="pdep$trace->id " href=# onclick="copier('pdep$trace->id ', 'Point GPS copié')">$trace->gps_dep</td>
            <td>$date_arr</td>
            <td><a id="pdep$trace->id " href=# onclick="copier('pdep$trace->id ', 'Point GPS copié')">$trace->gps_arr</td>
            <td><a href=# onclick="changeView('table', 'carte'); add_gpx('pages/troncons/trace$trace->id.gpx', 1)">Visualiser</a></td>
            <td><a href="pages/troncons/trace$trace->id.gpx" download>Télécharger</button></td>
        </tr>
        FIN;
        }
        ?>
    </table>

    <div id="carte">
        <button onclick="changeView('carte', 'table')">Retourner à la liste</button>
        <div id="map2"></div>
    </div>

    <div id="cs-popup-area"></div>
</div>



<script src="../scripts/map.js"></script>