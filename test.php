<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

Voici mon ex qui fonctionne (KML et GPX). Et finalement, le meilleur rendu de trace est KML

type="text/javascript"
src="http://api.ign.fr/geoportail/api?v=1.0beta4&amp;key=XXXXXXXXXX&amp;instance=TROISSEIGNEURS">
<!-- -->
</script>

<script type="text/javascript">

function initGeoportalMap() {
geoportalLoadTROISSEIGNEURS("GeoportalVisuDiv", "normal");

// Exemple avec un code territoire (ici la TROISSEIGNEURS)
// Snapshot with a territory code (here TROISSEIGNEURS)
// geoportalLoadVISU("GeoportalVisuDiv", "normal", "GLP");
TROISSEIGNEURS.getMap().setCenterAtLonLat("01° 25' 39\" E","42° 49' 04\" N",13);
//Ajout d'une couche GPX ou KML
TROISSEIGNEURS.addGeoportalLayers();

//-----------------add kml--------------
TROISSEIGNEURS.getMap().addLayer(
"KML",
"3 Seigneurs",
"troisseigneurs.kml",
{
visibility:true,
extractStyles:true
});

//--------------fin add kml--------------

// deb add gpx
//TROISSEIGNEURS.getMap().addLayer(
// "GPX",
// "trace trois seigneurs",
// "troisseigneurs.gpx",
// {
// visibility:true,
// extractStyles:true
// }
// );
// fin add gpx
// fin gpx

}

</script>
<style type="text/css">
<!--
.Style1 {
color: #00CC99;
font-weight: bold;
}
-->
</style>
</head>


<body>
  
</body>
</html>