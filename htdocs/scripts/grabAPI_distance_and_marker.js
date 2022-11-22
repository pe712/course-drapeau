const eventId = "6336f41309be310001a5894b";
const pollingRate = 1; // polling frequency in seconds

const url = `https://racemap.com/api/data/v1/${eventId}/current`;

const markers = new Map();
const myIcon = new L.icon({
    iconUrl: 'lib/leaflet/images/running.png',
    iconSize: [40, 40],
})
function sleep(repeatInterval) {
    return new Promise((resolve) => setTimeout(resolve, repeatInterval));
}

function distanceInKilometers(distanceInMeters) {
    let distance = distanceInMeters / 1000
    return Math.round(distance * 100) / 100;
}

function buildCounter(current) {
    console.log(`${distanceInKilometers(current.fromStart)} kilometres parcourus depuis le depart`)
}

function buildMarker(starter) {
    let current = starter.current;
    if (!markers.has(starter.id)) {
        let marker1 = new L.Marker([current.lat, current.lng], { icon: myIcon });
        let marker2 = new L.Marker([current.lat, current.lng], { icon: myIcon });
        marker1.addTo(map1);
        marker2.addTo(map2);
        markers.set(starter.id, [marker1, marker2]);
    }
    else {
        markers.get(starter.id).forEach(marker => {
            marker.setLatLng(L.latLng(current.lat, current.lng));
        });
    }
}


async function callAPI() {
    while (true) {
        let response = fetch(url) // Promise element
            .then((res) => res.json())
        response.then((out) => {
            out.starters.forEach(starter => {
                if (starter.current == null) {
                    console.log(`balise ${starter?.name} id=${starter.id} non localisee`);
                }
                else {
                    let current = starter.current;
                    buildCounter(current);
                    buildMarker(starter);
                }
            });
        })
        await sleep(pollingRate * 1000);
    }
}

let startCall = callAPI();