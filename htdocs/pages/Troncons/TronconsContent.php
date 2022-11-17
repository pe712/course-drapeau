<div class="btn-group adminView default-margin" role="group" aria-label="Basic radio toggle button group" id="troncons-switch">
    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" onclick="changeView('map', 'tronconsListe')" checked>
    <label class="btn btn-outline-primary" for="btnradio1">Liste</label>

    <input type="radio" class="btn-check " name="btnradio" id="btnradio2" onclick="changeView('tronconsListe', 'map'); add_gpx('pages/Troncons/traces/trace_complete.gpx', 0)">
    <label class="btn btn-outline-primary" for="btnradio2">Visualisation parcours complet</label>
</div>



<div id="map"></div>



<div id="tronconsListe">
    <table id="troncons-table" class="table table-striped table-hover">
        <tr>
            <th style="width:10px">Numéro tronçon</th>
            <th>Groupe de coureurs</th>
            <th>Heure de départ</th>
            <th>Point GPS de départ</th>
            <th>Heure arrivée</th>
            <th>Point GPS arrivée</th>
            <th id="troncons-column-visualize">Voir sur la carte</th>
            <th>Télécharger la trace</th>
        </tr>
        <?php
        include("colors.php");
        $traces = GPX::getGPXdata();
        while ($trace = $traces->fetch()) {
            $date_dep = new DateTime();
            $date_arr = new DateTime();
            $date_dep->setTimestamp($trace->heure_dep);
            $date_arr->setTimestamp($trace->heure_arr);
            $date_dep = date_format($date_dep, "l H:i");
            $date_arr = date_format($date_arr, "l H:i");
            $gps_dep = htmlspecialchars($trace->gps_dep);
            $url_gps_dep = urlencode($gps_dep);
            $gps_arr = htmlspecialchars($trace->gps_arr);
            $url_gps_arr = urlencode($gps_arr);
            if ($trace->trinome_id == null)
                $trinome = "A venir";
            elseif ($trace->trinome_id == -1) {
                $trinome = "tous";
                $color = $colors[12];
            } else {
                $trinome = $trace->trinome_id;
                $color = $colors[$trinome - 1];
            }
            echo <<<FIN
        <tr>
            <td>$trace->id</td>
            <td style="background-color: $color">$trinome</td>
            <td>$date_dep</td>
            <td>
                <a href="https://www.google.fr/maps/search/$url_gps_dep" target="_blank" id="pdep$trace->id">$gps_dep</a>
                <button class="troncons-button">
                    <img class="troncons-icon" src="img/icons/clipboard.png" alt="copy to clipboard" onclick="copier('pdep$trace->id', 'Point GPS copié dans le presse-papier')">
                </button>
            </td>
            <td>$date_arr</td>
            <td>
            <a href="https://www.google.fr/maps/search/$url_gps_arr" target="_blank" id="parr$trace->id">$gps_arr</a>
                <button class="troncons-button">
                    <img class="troncons-icon" src="img/icons/clipboard.png" alt="copy to clipboard" onclick="copier('parr$trace->id', 'Point GPS copié dans le presse-papier')">
                </button>
            </td>
            <td><button class="troncons-button" onclick="changeView('troncons-table', 'carte'); add_gpx('pages/Troncons/traces/trace$trace->id.gpx', 1)">Visualiser</button></td>
            <td><a href="pages/Troncons/traces/trace$trace->id.gpx" download>Télécharger</a></td>
        </tr>
FIN;
        }
        ?>
    </table>

    <div id="carte">
        <button class="btn btn-primary" onclick="changeView('carte', 'troncons-table')">Retourner à la liste</button>
        <div id="map2"></div>
    </div>

    <div id="cs-popup-area"></div>

</div>

<script src="scripts/map.js"></script>