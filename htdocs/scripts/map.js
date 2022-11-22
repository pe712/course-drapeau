function add_map(name) {
    var map = L.map(name);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    return map
}

if (document.getElementById('map'))
    var map1 = add_map('map');
else
    var map1 = null;

var map2 = add_map('map2')
var maps = [map1, map2];
var traces = []


// num est le numéro de la carte (0 pour la carte globale)
function add_gpx(file, num) {
    var map = maps[num];
    if (num == 0 && !(num in traces)) {
        // on ne crée qu'une seule fois
        traces[num] = create_gpx(file, map)
    }
    else if (num == 1) {
        if (num in traces)
            traces[num].clearLayers();
        traces[num] = create_gpx(file, map);
    }
}

function create_gpx(url, map) {
    var parameters = {
        async: true,
        marker_options: {
            startIconUrl: 'lib/leaflet/images/marker-icon.png',
            endIconUrl: 'lib/leaflet/images/marker-icon.png',
            shadowUrl: 'lib/leaflet-gpx/pin-shadow.png'
        }
    }
    var gpx_trace = new L.GPX(url, parameters).on('loaded', function (e) {
        map.fitBounds(e.target.getBounds());
    }).addTo(map);
    return gpx_trace;
}