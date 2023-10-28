function datatable(tb, url, columns, serverSide = true, drawCallback, bPaginate = true, createdRow = null, order = []) {
    let columnDefs = [];
    $.each(columns, function (k, v) {
        columnDefs[k] = v;
        columnDefs[k]['targets'] = k;
    })

    $('#' + tb).DataTable({
        processing: true,
        serverSide: serverSide,
        // responsive: true,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        ajax: url,
        fnRowCallback: function (
            nRow,
            aData,
            iDisplayIndex,
            iDisplayIndexFull
        ) {
            // debugger;
            var numStart = this.fnPagingInfo().iStart;
            var index = numStart + iDisplayIndexFull + 1;
            // var index = iDisplayIndexFull + 1;
            $("td:first", nRow).html(index);
            return nRow;
        },
        order: order,
        createdRow: createdRow,
        columnDefs: columnDefs,
        columns: columns,
        drawCallback: drawCallback,
        bPaginate: bPaginate
        // scrollX: true,
    });
    // }).columns.adjust().responsive.recalc();
}

function BasicDatatableGenerator(element, url = '/', col = [], colDef = [], data = function () {
}, extConfig = {}) {
    let baseConfig = {
        scrollX: true,
        processing: true,
        ajax: {
            type: 'GET',
            url: url,
            'data': data
        },
        columnDefs: colDef,
        columns: col,
        paging: true,
    };
    let config = {...baseConfig, ...extConfig};
    return $(element).DataTable(config).columns.adjust().responsive.recalc();
}
