var map_container;

function generateMap(element, single = false) {
    var center_indonesia = {
        lat: -0.4029326, lng: 110.5938779
    };
    map_container = L.map(element).setView([center_indonesia['lat'], center_indonesia['lng']], 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map_container);
    if (single) {

    } else {
        getPlacesData().then(r => {
        });
    }
}

function createMarker(geoJsonPayload) {
    L.geoJSON(geoJsonPayload, {
        pointToLayer: function (geoJsonPoint, latlng) {
            let icon_url = geoJsonPoint['properties']['type'] !== null ? window.location.origin + geoJsonPoint['properties']['type']['icon'] : '';
            var greenIcon = L.icon({
                iconUrl: icon_url,
                iconSize: [40, 40], // size of the icon
                iconAnchor: [40, 40], // point of the icon which will correspond to marker's location
                popupAnchor: [-3, -76] // point from which the popup should open relative to the iconAnchor
            });
            return L.marker(latlng, {icon: greenIcon});
        }
    }).bindPopup(function (layer) {
        return ('<div class="my-2"><strong>Place Name</strong> :<br>' + layer.feature.properties.name + '</div> <div class="my-2"><strong>Description</strong>:<br>' + layer.feature.properties.address + '</div><div class="my-2"><strong>Address</strong>:<br>' + layer.feature.properties.address + '</div>');
    }).addTo(map_container);
}

async function getPlacesData() {
    try {
        let response = await $.get('/cek-map/data?province=' + s_provinsi + '&city=' + s_kota + '&type=' + s_tipe + '&position=' + s_posisi);
        let geoJSONPayload = response['payload'];
        createMarker(geoJSONPayload);
        let tmp_bound = [];
        let features_data = response['payload']['features'];
        $.each(features_data, function (k, v) {
            tmp_bound.push([
                v['properties']['latitude'],
                v['properties']['longitude'],
            ]);
        });
        map_container.fitBounds(tmp_bound);
    } catch (e) {
        console.log(e);
    }
}

function createSingleMarker() {

}
