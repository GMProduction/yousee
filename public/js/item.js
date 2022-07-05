let image1, image2, image3;
var s_provinsi, s_kota, s_tipe, s_posisi;

var center = {
    lat: -7.57797433093528,
    lng: 110.80924297710521
};

function onTabChange() {
    $('#pills-tab').on('shown.bs.tab', function (e) {
        if (e.target.id === 'pills-peta-tab') {
            generateMap('main-map');
        }
    })
}

function onTabDetailChange() {
    $('#pills-tab-detail').on('shown.bs.tab', function (e) {
        if (e.target.id === 'pills-maps-tab-detail') {
            let id = $('#d-id').val();
            generateSingleMap('map-detail', id);
        }
    })
}

$(document).on('change', '#province', function () {
    let id = $(this).val();
    getSelect('city', '/admin/province/' + id + '/city');
});

$(document).on('change', '#f-provinsi', function (ev) {
    s_provinsi = $(this).val();
    if (s_provinsi === '') {
        getSelect('f-kota', '/admin/city', 'name', null, 'Semua Kota');
    } else {
        getSelect('f-kota', '/admin/province/' + s_provinsi + '/city', 'name', null, 'Semua Kota');
    }
    let text = ev.currentTarget.options[ev.currentTarget.selectedIndex].text;
    pillSearch('provinsi', text);
    datatableItem();
    getPlacesData();
});
$(document).on('change', '#f-kota', function (ev) {
    s_kota = $(this).val();
    let text = ev.currentTarget.options[ev.currentTarget.selectedIndex].text;
    pillSearch('kota', text);
    datatableItem();
    getPlacesData();
});

$(document).on('change', '#f-tipe', function (ev) {
    s_tipe = $(this).val();
    let text = ev.currentTarget.options[ev.currentTarget.selectedIndex].text;
    pillSearch('tipe', text);
    datatableItem();
    getPlacesData();
});

$(document).on('change', '#f-posisi', function (ev) {
    s_posisi = $(this).val();
    let text = ev.currentTarget.options[ev.currentTarget.selectedIndex].text;
    pillSearch('posisi', text);
    datatableItem();
    getPlacesData();
});

function pillSearch(a, text) {
    let pill = $('#pillSearch');
    let child = document.getElementById('pill' + a);
    console.log('aaa', a);
    console.log('text', text);
    if (child) {
        $('#pill' + a + ' #text').html(text)
    } else {
        pill.append('<span class="badge bg-primary me-2 " id="pill' + a +
            '" style="border-radius: 200px; align-items: center"><span id="text">' + text +
            '</span>  <a role="button" id="removePill" data-id="' + a +
            '"><i class="material-icons" style="font-size: 12px">close</i></a></span>')
    }
    //

}

$(document).on('click', '#removePill', function () {
    let id = $(this).data('id');
    let parent = document.getElementById('pillSearch');
    let child = document.getElementById('pill' + id);
    parent.removeChild(child);
    $('#f-' + id).val('');
    window['s_' + id] = '';
    datatableItem();
    getPlacesData();
});

$(document).on('click', '#addData, #editData',async function () {
    let id = $(this).data('id');
    let data = $(this).data('row');
    console.log(id);
    console.log(data);
    $('#form #id').val(id);
    $('#form input[type="text"]').val('');
    $('#form input[type="number"]').val('');
    $('#form select').val('');
    let fileImg1 = null,
        fileImg2 = null,
        fileImg3 = null,
        prov = null, vendor = null;
    $('#city').empty();
    if (id) {
        let url = await getUrl(data.id);

        prov = data.city.province.id;
        vendor = data.vendor?.id;
        $('#form #name').val(data.name);
        $('#form #address').val(data.address);
        $('#form #location').val(data.location);
        $('#form #url_show').val(data.url_show);
        $('#form #urlstreetview').val(url);
        $('#form #latlong').val(data.latitude+', '+data.longitude);
        $('#form #position').val(data.position);
        $('#form #type').val(data.type);
        $('#form #height').val(data.height);
        $('#form #width').val(data.width);
        getSelect('city', '/admin/province/' + data.city.province.id + '/city', 'name', data.city.id);

        fileImg1 = data.image1;
        fileImg2 = data.image2;
        fileImg3 = data.image3;
    }
    getSelect('province', '/admin/province', 'name', prov);
    getSelect('vendor', '/admin/vendor/all', 'name', vendor);

    setImgDropify('image1', null, fileImg1);
    setImgDropify('image2', null, fileImg2);
    setImgDropify('image3', null, fileImg3);
    $('#modaltambahtitik').modal('show');
})

$('#modaldetail').on('shown.bs.modal', function () {
    $('#pills-detail-tab').tab('show');
    onTabDetailChange();
});

$('#modaldetail').on('show.bs.modal', function () {
    $('#pills-detail-tab').tab('show');
});

$('#modaldetail').on('hidden.bs.modal', function () {

});

$(document).on('click', '#detailData', async function () {
    let data = $(this).data('row');
    let url = await getUrl(data.id);

    $('#d-id').val(data.id);
    $('#d-name').html(data.name);
    $('#d-provinsi').val(data.city?.province?.name);
    $('#d-kota').val(data.city?.name);
    $('#d-alamat').val(data.address);
    $('#d-lokasi').val(data.location);
    $('#d-tipe').val(data.type?.name);
    $('#d-urlstreetview').val(url);
    $('#d-latlong').val(data.latitude+', '+data.longitude);
    $('#d-posisi').val(data.position);
    $('#d-panjang').val(data.height);
    $('#d-lebar').val(data.width);
    $('#d-Vendor').val(data.vendor?.name);
    $('#openTapGmap').removeAttr('href').attr('href', data.url_show);
    $('#showImg1').empty();
    $('#showImg2').empty();
    $('#showImg3').empty();
    $('#downlodShowImg1').removeAttr('href').removeAttr('download');
    $('#downlodShowImg2').removeAttr('href').removeAttr('download');
    $('#downlodShowImg2').removeAttr('href').removeAttr('download');
    if (data.image1) {
        $('#showImg1').html('<img src="' + data.image1 + '"  alt=""/>')
        $('#downlodShowImg1').attr('href',data.image1 ).attr('download','image1')
    }
    if (data.image2) {
        $('#showImg2').html('<img src="' + data.image2 + '"  alt=""/>')
        $('#downlodShowImg2').attr('href',data.image2 ).attr('download','image2')
    }
    if (data.image3) {
        $('#showImg3').html('<img src="' + data.image3 + '"  alt=""/>')
        $('#downlodShowImg3').attr('href',data.image3 ).attr('download','image3')
    }
    showStreetView(url);
    $('#modaldetail').modal('show')
});

function datatableItem() {
    let formData = {
        'province': s_provinsi,
        'city': s_kota,
        'type': s_tipe,
        'position': s_posisi
    };
    let stringData = JSON.stringify(formData);
    var url = '/admin/item/datatable';

    $('#table_id').DataTable({
        destroy: true,
        processing: true,
        serverSide: true,
        ajax: {
            'url': url,
            "data": formData
        },
        "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            // debugger;
            var numStart = this.fnPagingInfo().iStart;
            var index = numStart + iDisplayIndexFull + 1;
            // var index = iDisplayIndexFull + 1;
            $("td:first", nRow).html(index);
            return nRow;
        },
        columns: [{
            "className": '',
            "orderable": false,
            "data": null,
            "defaultContent": ''
        },
            {
                "data": "city.name",
                "name": "city.name"
            },
            {
                "data": "name",
                "name": "name"
            },
            {
                "data": "address",
                "name": "address"
            },
            {
                "data": "vendor.name",
                "name": "vendor.name",
                "render": function (data) {
                    return data ?? '-';
                }
            },
            {
                "data": "height",
                "name": "height"
            },
            {
                "data": "width",
                "name": "width"
            },
            {
                "data": "type.name",
                "name": "type.name"
            },
            {
                "data": "position",
                "name": "position"
            },
            {
                "data": "created_by.nama",
                "name": "created_by.nama"
            },
            {
                "data": "last_update.nama",
                "render": function (data, type, row) {
                    return '<div class="d-flex">' +
                        '<span class="me-2">' + data + '</span>' +
                        '<a class="btn-sm btn-danger-soft" data-name="' + row.name + '" data-id="' +
                        row.id +
                        '" id="btnHistory" style="width: 10px"><i class="material-icons" style="font-size: 12px">history</i></a></div>'
                }
            },
            {
                "data": "id",
                "render": function (data, type, row) {
                    delete row['url'];
                    let string = JSON.stringify(row);
                    return "<div class='d-flex'><a class='btn-utama-soft sml rnd me-1' data-row='" +
                        string + "'  \n" +
                        "                                                  id='detailData'> <i class='material-icons menu-icon'>map</i></a>\n" +
                        "                                <a class='btn-success-soft sml rnd' data-id='" +
                        data + "' data-row='" + string +
                        "' id='editData'> <i class='material-icons menu-icon'>edit</i></a></div>";
                }
            },
        ]
    });

}

function saveItem() {
    let form = $('#form');
    form.submit(async function (e) {
        e.preventDefault(e);
        let formData = new FormData(this);
        console.log(formData);
        // if ($('#image1').val()) {
        //     let img = await handleImageUpload($('#image1'));
        //     formData.append('image1', img, img.name)
        // }
        // if ($('#image2').val()) {
        //     let img = await handleImageUpload($('#image2'));
        //     formData.append('image2', img, img.name)
        // }
        // if ($('#image3').val()) {
        //     let img = await handleImageUpload($('#image3'));
        //     formData.append('image3', img, img.name)
        // }
        let data = {
            'form_data': formData,
            'image': {
                'image1': 'image1',
                'image2': 'image2',
                'image3': 'image3',
            }
        }
        saveDataAjaxWImage('Simpan Data', 'form', data, '/admin/item/post-item',
            afterSave);
        return false;
    })
}

function afterSave() {
    $('#modaltambahtitik').modal('hide');
    datatableItem();
}

$(document).on('click', '#btnHistory', function () {

    var id = $(this).data('id');
    var name = $(this).data('name');
    let tabel = $('#bodyHistory');
    tabel.empty();
    $.get('/admin/history/' + id, function (data) {
        if (data.length > 0) {
            $.each(data, function (k, v) {
                let string = k === parseInt(data.length - 1) ? v.user.nama + ' ( create )' :
                    v.user.nama;
                moment.locale('id');

                tabel.append('<tr>' +
                    '             <td>' + parseInt(k + 1) + '</td>' +
                    '             <td>' + string + '</td>' +
                    '             <td>' + moment(v.created_at).format('LLLL') +
                    '</td>' +
                    '         </tr>');

            })
        }
    })

    $('#modalHistory #titleHistory').html(name);
    $('#modalHistory').modal('show');
})

async function showStreetView(url) {
    var panel = $('#panel-street');
    panel.empty();

    // var url = await getUrl(id);
    // if (url) {
    panel.html(url);
    let frame = $('#panel-street iframe')[0];
    if (frame){
        $('#panel-street iframe').removeAttr('width').attr('width','100%');
    }
    // }
}

async function getUrl(id) {
    let url;
    await $.get('/admin/item/url-street-view/' + id, function (data) {
        url = data;
    })
    return url;
}
