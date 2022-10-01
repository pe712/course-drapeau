var map = L.map('map');
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

function add_gpx(file) {
    var url = file; // URL to your GPX file or the GPX itself
    new L.GPX(url, {
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



