<table>
    <tr>
        <th>Numéro troncon</th>
        <th>Heure de départ</th>
        <th>Point GPS de départ</th>
        <th>Heure arrivée</th>
        <th>Point GPS arrivée</th>
        <th>Télécharger la trace</th>
    </tr>
    <?php
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
