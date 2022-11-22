function add_map(name) {
    let map = L.map(name);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    return map
}

if (document.getElementById('map'))
    let map1 = add_map('map');
else
    let map1 = null;

let map2 = add_map('map2')
let maps = [map1, map2];
let traces = []


// num est le numéro de la carte (0 pour la carte globale)
function add_gpx(file, num) {
    let map = maps[num];
    if (num == 0 && !(num in traces)) {
        traces[num] = create_gpx(file, map)
    }
    else if (num == 1) {
        if (num in traces)
            traces[num].clearLayers();
        traces[num] = create_gpx(file, map);
    }
}

function create_gpx(url, map) {
    let parameters = {
        async: true,
        marker_options: {
            startIconUrl: 'lib/leaflet/images/marker-icon.png',
            endIconUrl: 'lib/leaflet/images/marker-icon.png',
            shadowUrl: 'lib/leaflet-gpx/pin-shadow.png'
        }
    }
    let gpx_trace = new L.GPX(url, parameters).on('loaded', function (e) {
        map.fitBounds(e.target.getBounds());
    }).addTo(map);
    return gpx_trace;
}
// let marker = new L.Marker([44.83743 - 0.57733]);
// marker.addTo(map1);