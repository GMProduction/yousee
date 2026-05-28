var map_container;
var map_container_single;
var center_indonesia = {
    lat: -0.4029326, lng: 110.5938779
};

// function generateMap(element) {
//     if (map_container === undefined) {
//         map_container = L.map(element).setView([center_indonesia['lat'], center_indonesia['lng']], 5);
//         L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//             maxZoom: 19,
//             attribution: '© OpenStreetMap'
//         }).addTo(map_container);
//     }
//     getPlacesData().then(r => {
//     });
// }
//
//
// function createMarker(geoJsonPayload) {
//     L.geoJSON(geoJsonPayload, {
//         pointToLayer: function (geoJsonPoint, latlng) {
//             let icon_url = geoJsonPoint['properties']['type'] !== null ? window.location.origin + geoJsonPoint['properties']['type']['icon'] : '';
//             var greenIcon = L.icon({
//                 iconUrl: icon_url,
//                 iconSize: [40, 40], // size of the icon
//             });
//             return L.marker(latlng, {icon: greenIcon});
//         }
//     }).bindPopup(function (layer) {
//         return ('<div class="my-2"><strong>Place Name</strong> :<br>' + layer.feature.properties.name + '</div> <div class="my-2"><strong>Description</strong>:<br>' + layer.feature.properties.address + '</div><div class="my-2"><strong>Address</strong>:<br>' + layer.feature.properties.address + '</div>');
//     }).addTo(map_container);
// }
//
// async function getPlacesData() {
//     try {
//         let response = await $.get('/cek-map/data?province=' + s_provinsi + '&city=' + s_kota + '&type=' + s_tipe + '&position=' + s_posisi);
//         let geoJSONPayload = response['payload'];
//         createMarker(geoJSONPayload);
//         let tmp_bound = [];
//         let features_data = response['payload']['features'];
//         $.each(features_data, function (k, v) {
//             tmp_bound.push([
//                 v['properties']['latitude'],
//                 v['properties']['longitude'],
//             ]);
//         });
//         map_container.fitBounds(tmp_bound);
//     } catch (e) {
//         console.log(e);
//     }
// }
//
// function generateSingleMap(element, id) {
//     if (map_container_single === undefined) {
//         map_container_single = L.map(element).setView([center_indonesia['lat'], center_indonesia['lng']], 16);
//         L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//             maxZoom: 19,
//             attribution: '© OpenStreetMap'
//         }).addTo(map_container_single);
//     }
//     getDetailPlace(id).then(r => {
//     })
// }
//
// async function getDetailPlace(id) {
//     try {
//         let response = await $.get('/cek-map/data-detail/' + id);
//         removeSingleMarkerLayer();
//         createSingleMarker(response['payload'])
//     } catch (e) {
//         console.log(e);
//     }
// }
//
// function createSingleMarker(payload) {
//     let coordinate = [payload['latitude'], payload['longitude']];
//     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//         maxZoom: 19,
//         attribution: '© OpenStreetMap'
//     }).addTo(map_container_single);
//     var layerGroup = L.layerGroup();
//     let icon_url = payload['type'] !== null ? window.location.origin + payload['type']['icon'] : '';
//     var greenIcon = L.icon({
//         iconUrl: icon_url,
//         iconSize: [40, 40], // size of the icon
//     });
//     let marker = L.marker(coordinate, {icon: greenIcon});
//     marker.bindPopup(
//         '<div class="my-2"><strong>Place Name</strong> :<br>' + payload.name + '</div> <div class="my-2"><strong>Description</strong>:<br>' + payload.address + '</div><div class="my-2"><strong>Address</strong>:<br>' + payload.address + '</div>');
//     layerGroup.addLayer(marker)
//     map_container_single.addLayer(layerGroup);
//     map_container_single.panTo(new L.LatLng(payload['latitude'], payload['longitude']));
// }
//
// function removeSingleMarkerLayer() {
//     if(map_container_single !== undefined) {
//         map_container_single.eachLayer(function (layer) {
//             map_container_single.removeLayer(layer);
//         });
//     }
// }

function initMap() {
    const myLatLng = {lat: -7.5589494045543475, lng: 110.85658809673708};
    map_container = new google.maps.Map(document.getElementById("main-map"), {
        zoom: 14,
        center: myLatLng,
    });
}

async function generateGoogleMapData() {
  try {
    $("#map-loading").css("visibility", "visible");
    let response = await $.get(
      "/map/data?province=" +
        s_provinsi +
        "&city=" +
        s_kota +
        "&type=" +
        s_tipe +
        "&position=" +
        s_posisi
    );
    let payload = response["payload"];
    removeMultiMarker();
    if (payload.length > 0) {
      createGoogleMapMarker(payload);
    }
    $("#map-loading").css("visibility", "hidden");
  } catch (e) {
    console.log(e);
    $("#map-loading").css("visibility", "hidden");
  }
}


var multi_marker = [];
var markerCluster;

function removeMultiMarker() {
  for (i = 0; i < multi_marker.length; i++) {
    multi_marker[i].setMap(null);
  }
  multi_marker = [];
  if (markerCluster) {
    markerCluster.clearMarkers();
  }
}

function createGoogleMapMarker(payload = []) {
  var bounds = new google.maps.LatLngBounds();

  multi_marker = payload.map(function (v, k) {
    var marker = new google.maps.Marker({
      position: new google.maps.LatLng(v["latitude"], v["longitude"]),
      icon: v["type"]["icon"],
      title: v["name"],
    });

    let infowindow = new google.maps.InfoWindow({
      content: windowContent(v, k, role),
    });

    marker.addListener("click", function () {
      infowindow.open({
        anchor: marker,
        map: map_container,
        shouldFocus: false,
      });
    });
    bounds.extend(marker.position);
    return marker;
  });

  markerCluster = new markerClusterer.MarkerClusterer({
    map: map_container,
    markers: multi_marker,
  });

  if (payload.length > 0) {
    map_container.fitBounds(bounds);
  }
}

function windowContent(data, key, role = 'presence') {

    let vendor = '-';
    if (data['vendor_all'] !== null) {
        vendor = data['vendor_all']['name'];
    }

    let vendorElement = '';
    if (role !== 'presence') {
        vendorElement = '<p>Vendor : <span class="fw-bold">' + vendor + '</span></p>';
    }
    return '<div>' +
        '<p class="fw-bold">' + data['location'] + '</p>' +
        '<p>' + data['address'] + '</p>' + vendorElement +
        '<a onclick="openDetail(this)"  href="#" style="font-size: 10px;" class="btn-detail-item" data-id="' + data['id'] + '">Lihat Detail</a>' +
        '</div>';

}

async function openDetail(element) {
    event.preventDefault()
    let id = element.dataset.id;
    await generateSingleGoogleMapData(id);
    $('#simple-modal-detail').modal('show');
}

async function generateSingleGoogleMapData(id) {
    try {
        let payload = id;
        if (typeof id == 'string'){
            let response = await $.get('/map/data/' + id);
            payload = response.payload;
        }else{
            const url = await getUrl(id.id);
            payload.url = url;
        }

        const location = {lat: payload['latitude'], lng: payload['longitude']};
        map_container_single = new google.maps.Map(document.getElementById("single-map-container"), {
            zoom: 16,
            center: location,
        });
        new google.maps.Marker({
            position: new google.maps.LatLng(payload['latitude'], payload['longitude']),
            map: map_container_single,
            icon: payload['type']['icon'],
            title: payload['name'],
        });
        generateDetail(payload);
    } catch (e) {
        console.log(e);
    }
}

function generateDetail(data) {
    let vendor = data['vendor_all'] || {};
    let vendorName = vendor['name'] || '';
    let vendorBrand = vendor['brand'] || '';
    let vendorAddress = vendor['address'] || '';
    let vendorEmail = vendor['email'] || '';
    let vendorPhone = vendor['picPhone'] || '';
    let vendorPic = vendor['picName'] || '';

    $('#detail-title-tipe').html(data['type']['name']);
    $('#detail-title-nama').html('( ' + (vendorName || '-') + ' )');
    // $('#single-map-container-street-view').html(data['url']);
    $('#detail-vendor').val(vendorName + (vendorBrand ? ' (' + vendorBrand + ')' : ''));
    $('#detail-vendor-address').val(vendorAddress);
    $('#detail-vendor-email').val(vendorEmail);
    $('#detail-vendor-phone').val(vendorPhone);
    $('#detail-vendor-phone-pic').val(vendorPhone);
    $('#detail-vendor-pic').val(vendorPic);
    $('#detail-provinsi').val(data['city'] && data['city']['province'] ? data['city']['province']['name'] : '');
    $('#detail-kota').val(data['city'] ? data['city']['name'] : '');
    $('#detail-alamat').val(data['address']);
    $('#detail-lokasi').val(data['location']);
    $('#detail-coordinate').val(data['latitude'] + ', ' + data['longitude']);
    $('#detail-tipe').val(data['type']['name']);
    $('#detail-posisi').val(data['position']);
    $('#detail-panjang').val(data['height']);
    $('#detail-lebar').val(data['width']);
    $('#detail-qty').val(data['qty']);
    $('#detail-side').val(data['side']);
    $('#detail-trafic').val(data['trafic']);
    $('#single-map-container-street-view').html(data['url']);
    $('#detail-gambar-1').attr('src', data['image1']);
    $('#detail-gambar-2').attr('src', data['image2']);
    $('#detail-gambar-3').attr('src', data['image3']);
    $('#link-gbr1').attr('href', data['image3']);
    $('#dwnld-gbr1').attr('href', data['image3']);
    $('#dwnld-gbr1').attr('download', data['image3']);
    $('#link-gbr2').attr('href', data['image3']);
    $('#dwnld-gbr2').attr('href', data['image3']);
    $('#dwnld-gbr2').attr('download', data['image3']);
    $('#link-gbr3').attr('href', data['image3']);
    $('#dwnld-gbr3').attr('href', data['image3']);
    $('#dwnld-gbr3').attr('download', data['image3']);

    let num = '';
    if (vendorPhone) {
        let splitNumber = vendorPhone.split('/');
        num = splitNumber[0].split(' ').join('');
        const first = num.substring(0, 1);
        if (first == 0){
            num = '62'+num.substring(1);
        }
        console.log('firstfirstfirst', first);
        console.log('2222222222', num);
    }
    // console.log(window.location.hostname);
    // const img = data['image1'];
    //
    // navigator.clipboard.writeText(copyText.value);
    const text = 'Apakah '+data['type']['name']+' yang berlokasi di '+(data['city'] ? data['city']['name'] : '')+' '+data['address']+' '+data['location']+' tersedia ?';
    $('.sendWa').attr('href','https://wa.me/'+num+'?text='+encodeURI(text)).attr('target','_blank');

    // Load duplicate coordinates
    loadDuplicates(data['id']);
}

function loadDuplicates(itemId) {
    const container = $('#detail-duplicate-container');
    container.html('<div class="text-center text-muted py-3">Loading...</div>');
    
    // Switch to first tab (Detail) by default when a new detail is loaded
    $('#pills-single-detail-tab').tab('show');
    
    $.get('/data/item/by-id/' + itemId + '/duplicates', function(res) {
        container.empty();
        if (res.length === 0) {
            container.html('<div class="text-center text-muted py-3">Tidak ada data duplikat ditemukan.</div>');
            return;
        }
        
        res.forEach(function(item) {
            let imgHtml = item.image1 ? 
                '<img src="' + item.image1 + '" class="img-fluid rounded-start" style="object-fit: cover; height: 100%; width: 100%; min-height: 120px;" alt="Gambar Vendor">' :
                '<div class="d-flex align-items-center justify-content-center bg-light text-muted rounded-start" style="height: 100%; min-height: 120px; font-size: 11px; width: 100%;"><span class="d-flex flex-column align-items-center"><i class="material-symbols-outlined mb-1" style="font-size: 24px">image</i>Tanpa Gambar</span></div>';

            container.append(
                '<div class="card mb-3 shadow-sm border" style="border-radius: 8px; overflow: hidden; background: #fff;">' +
                '  <div class="row g-0">' +
                '    <div class="col-sm-4 d-flex align-items-stretch" style="background: #f8f9fa;">' +
                imgHtml +
                '    </div>' +
                '    <div class="col-sm-8">' +
                '      <div class="card-body p-3" style="font-size: 12px; line-height: 1.5; color: #333;">' +
                '        <div class="d-flex justify-content-between align-items-center mb-2">' +
                '          <span class="badge bg-primary" style="font-size: 10px; border-radius: 4px;">' + item.type + '</span>' +
                '          <span class="badge bg-warning text-dark" style="font-size: 10px; border-radius: 4px;">Kemiripan: ' + item.similarity + '</span>' +
                '        </div>' +
                '        <p class="mb-1 fw-bold text-primary" style="font-size: 13px;"><i class="material-symbols-outlined align-middle me-1" style="font-size: 14px">location_on</i>' + item.province + ', ' + item.city + '</p>' +
                '        <p class="mb-1" style="color: #555;"><strong>Alamat:</strong> ' + item.address + '</p>' +
                '        <p class="mb-1"><strong>Ukuran:</strong> ' + item.height + ' x ' + item.width + '</p>' +
                '        <p class="mb-1"><strong>Vendor:</strong> ' + item.vendor + '</p>' +
                '        <p class="mb-2" style="color: #666;"><strong>Koordinat:</strong> ' + item.latitude + ', ' + item.longitude + '</p>' +
                '        <div class="d-flex justify-content-end">' +
                '          <button class="btn btn-sm btn-utama-soft view-duplicate-detail" data-id="' + item.id + '" style="border-radius: 4px; display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; font-size: 11px;">' +
                '            <i class="material-symbols-outlined" style="font-size: 14px">visibility</i> Lihat Detail' +
                '          </button>' +
                '        </div>' +
                '      </div>' +
                '    </div>' +
                '  </div>' +
                '</div>'
            );
        });
    }).fail(function() {
        container.html('<div class="text-center text-danger py-3">Gagal memuat data duplikat.</div>');
    });
}

$(document).on('click', '.view-duplicate-detail', function() {
    let id = $(this).data('id');
    // Load the detail for this duplicate item in-place in the modal
    generateSingleGoogleMapData(id.toString());
});
