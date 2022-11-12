var map1 = L.map('map');
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map1);

var map2 = L.map('map2');
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map2);

var maps = [map1, map2];
var traces = []
function add_gpx(file, num) {
    var map = maps[num];
    var url = file; // URL to your GPX file or the GPX itself
    if (num == 0 && !(num in traces)) {
        traces[num] = new L.GPX(url, {
            async: true,
            marker_options: {
                startIconUrl: 'lib/leaflet/images/marker-icon.png',
                endIconUrl: 'lib/leaflet/images/marker-icon.png',
                shadowUrl: 'lib/leaflet-gpx/pin-shadow.png'
            }
        }).on('loaded', function (e) {
            map.fitBounds(e.target.getBounds());
        }).addTo(map);
    }
    else if (num == 1) {
        if (num in traces)
            traces[num].clearLayers();
        traces[num] = new L.GPX(url, {
            async: true,
            marker_options: {
                startIconUrl: 'lib/leaflet/images/marker-icon.png',
                endIconUrl: 'lib/leaflet/images/marker-icon.png',
                shadowUrl: 'lib/leaflet-gpx/pin-shadow.png'
            }
        }).on('loaded', function (e) {
            map.fitBounds(e.target.getBounds());
        }).addTo(map);
    }
}
