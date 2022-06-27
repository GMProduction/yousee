var map_container;
var map_container_single;
var center_indonesia = {
    lat: -0.4029326, lng: 110.5938779
};

function generateMap(element) {
    if (map_container === undefined) {
        map_container = L.map(element).setView([center_indonesia['lat'], center_indonesia['lng']], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map_container);
    }
    getPlacesData().then(r => {
    });
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

function generateSingleMap(element, id) {
    if (map_container_single === undefined) {
        map_container_single = L.map(element).setView([center_indonesia['lat'], center_indonesia['lng']], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map_container_single);
    }
    getDetailPlace(id).then(r => {
    })
}

async function getDetailPlace(id) {
    try {
        let response = await $.get('/cek-map/data-detail/' + id);
        removeSingleMarkerLayer();
        createSingleMarker(response['payload'])
    } catch (e) {
        console.log(e);
    }
}

function createSingleMarker(payload) {
    let coordinate = [payload['latitude'], payload['longitude']];
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map_container_single);
    var layerGroup = L.layerGroup();
    // let icon_url = payload['type'] !== null ? window.location.origin + payload['type']['icon'] : '';
    // var greenIcon = L.icon({
    //     iconUrl: icon_url,
    //     iconSize: [40, 40], // size of the icon
    //     iconAnchor: [40, 40], // point of the icon which will correspond to marker's location
    //     popupAnchor: [-3, -76] // point from which the popup should open relative to the iconAnchor
    // });
    let marker = L.marker(coordinate
        // , {icon: greenIcon}
        );
    marker.bindPopup(
        '<div class="my-2"><strong>Place Name</strong> :<br>' + payload.name + '</div> <div class="my-2"><strong>Description</strong>:<br>' + payload.address + '</div><div class="my-2"><strong>Address</strong>:<br>' + payload.address + '</div>');
    layerGroup.addLayer(marker)
    map_container_single.addLayer(layerGroup);
    map_container_single.panTo(new L.LatLng(payload['latitude'], payload['longitude']));
}

function removeSingleMarkerLayer() {
    if(map_container_single !== undefined) {
        map_container_single.eachLayer(function (layer) {
            map_container_single.removeLayer(layer);
        });
    }
}
