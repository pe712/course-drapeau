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
    $troncons=array(
        array(            
            "num" => "Admin",
            "hdep" => "14",
            "pdep" => "14.54.5",
            "harr" => "15",
            "parr" => ".54.54827",
        ),
    );
    foreach ($troncons as $tronc){
        extract($tronc);
        echo <<<FIN
        <td>$num</td>
        <td>$hdep</td>
        <td>$pdep</td>
        <td>$harr</td>
        <td>$parr</td>
        <td><button>Télécharger la trace correspondante</button></td>
        FIN;
    }
    ?>
</table>
