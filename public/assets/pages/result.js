"use strict";

$("#maintenance-table").DataTable({
    pageLength: 10,
    processing: true,
    serverSide: true,
    responsive: true,
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, "Semua"],
    ],
    ajax: {
        url: maintenance,
        type: "GET",
    },
    dom: '<"html5buttons">lBrtip',
    oLanguage: {
        sEmptyTable: "Belum ada data",
    },
    columns: [
        {
            width: "5%",
            data: "DT_RowIndex",
            orderable: false,
            searchable: false,
        },
        { data: "code" },
        { data: "hardware_code" },
        { data: "brand" },
        { data: "mtbf" },
        { data: "mttr" },
        { data: "date" },
        { data: "availibility" },
    ],
    buttons: [
        {
            extend: "print",
            text: "Print Semua",
            exportOptions: {
                modifier: {
                    selected: null,
                },
                columns: ":visible",
            },
            messageTop: "Dokumen dikeluarkan tanggal " + moment().format("L"),
            // footer: true,
            header: true,
        },
        {
            extend: "csv",
        },
        {
            extend: "print",
            text: "Print Yang Dipilih",
            exportOptions: {
                columns: ":visible",
            },
        },
        {
            extend: "excelHtml5",
            exportOptions: {
                columns: ":visible",
            },
        },
        {
            extend: "pdfHtml5",
            exportOptions: {
                columns: [0, 1, 2, 5],
            },
        },
        {
            extend: "colvis",
            postfixButtons: ["colvisRestore"],
            text: "Sembunyikan Kolom",
        },
    ],
});

$('a[id="mtbf-tab"]').on("shown.bs.tab", function (e) {
    $("#maintenance-table").DataTable().destroy();
    $("#mttr-table").DataTable().destroy();
    $("#mtbf-table").DataTable({
        pageLength: 10,
        processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Semua"],
        ],
        ajax: {
            url: mtbf,
            type: "GET",
        },
        dom: '<"html5buttons">lBrtip',
        oLanguage: {
            sEmptyTable: "Belum ada data",
        },
        columns: [
            {
                width: "5%",
                data: "DT_RowIndex",
                orderable: false,
                searchable: false,
            },
            { data: "code" },
            { data: "hardware_code" },
            { data: "brand" },
            { data: "total_work" },
            { data: "total_breakdown" },
            { data: "breakdown" },
            { data: "time_breakdown" },
            { data: "total" },
        ],
        buttons: [
            {
                extend: "print",
                text: "Print Semua",
                exportOptions: {
                    modifier: {
                        selected: null,
                    },
                    columns: ":visible",
                },
                messageTop:
                    "Dokumen dikeluarkan tanggal " + moment().format("L"),
                // footer: true,
                header: true,
            },
            {
                extend: "csv",
            },
            {
                extend: "print",
                text: "Print Yang Dipilih",
                exportOptions: {
                    columns: ":visible",
                },
            },
            {
                extend: "excelHtml5",
                exportOptions: {
                    columns: ":visible",
                },
            },
            {
                extend: "pdfHtml5",
                exportOptions: {
                    columns: [0, 1, 2, 5],
                },
            },
            {
                extend: "colvis",
                postfixButtons: ["colvisRestore"],
                text: "Sembunyikan Kolom",
            },
        ],
    });
});

$('a[id="maintenance-tab"]').on("shown.bs.tab", function (e) {
    $("#mtbf-table").DataTable().destroy();
    $("#mttr-table").DataTable().destroy();
    $("#maintenance-table").DataTable({
        pageLength: 10,
        processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Semua"],
        ],
        ajax: {
            url: maintenance,
            type: "GET",
        },
        dom: '<"html5buttons">lBrtip',
        oLanguage: {
            sEmptyTable: "Belum ada data",
        },
        columns: [
            {
                width: "5%",
                data: "DT_RowIndex",
                orderable: false,
                searchable: false,
            },
            { data: "code" },
            { data: "hardware_code" },
            { data: "brand" },
            { data: "mtbf" },
            { data: "mttr" },
            { data: "date" },
            { data: "availibility" },
        ],
        buttons: [
            {
                extend: "print",
                text: "Print Semua",
                exportOptions: {
                    modifier: {
                        selected: null,
                    },
                    columns: ":visible",
                },
                messageTop:
                    "Dokumen dikeluarkan tanggal " + moment().format("L"),
                // footer: true,
                header: true,
            },
            {
                extend: "csv",
            },
            {
                extend: "print",
                text: "Print Yang Dipilih",
                exportOptions: {
                    columns: ":visible",
                },
            },
            {
                extend: "excelHtml5",
                exportOptions: {
                    columns: ":visible",
                },
            },
            {
                extend: "pdfHtml5",
                exportOptions: {
                    columns: [0, 1, 2, 5],
                },
            },
            {
                extend: "colvis",
                postfixButtons: ["colvisRestore"],
                text: "Sembunyikan Kolom",
            },
        ],
    });
});

$('a[id="mttr-tab"]').on("shown.bs.tab", function (e) {
    $("#maintenance-table").DataTable().destroy();
    $("#mtbf-table").DataTable().destroy();
    $("#mttr-table").DataTable({
        pageLength: 10,
        processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "Semua"],
        ],
        ajax: {
            url: mttr,
            type: "GET",
        },
        dom: '<"html5buttons">lBrtip',
        oLanguage: {
            sEmptyTable: "Belum ada data",
        },
        columns: [
            {
                width: "5%",
                data: "DT_RowIndex",
                orderable: false,
                searchable: false,
            },
            { data: "code" },
            { data: "hardware_code" },
            { data: "brand" },
            { data: "total_maintenance" },
            { data: "time_maintenance" },
            { data: "total_repair" },
            { data: "start_time" },
            { data: "total" },
        ],
        buttons: [
            {
                extend: "print",
                text: "Print Semua",
                exportOptions: {
                    modifier: {
                        selected: null,
                    },
                    columns: ":visible",
                },
                messageTop:
                    "Dokumen dikeluarkan tanggal " + moment().format("L"),
                // footer: true,
                header: true,
            },
            {
                extend: "csv",
            },
            {
                extend: "print",
                text: "Print Yang Dipilih",
                exportOptions: {
                    columns: ":visible",
                },
            },
            {
                extend: "excelHtml5",
                exportOptions: {
                    columns: ":visible",
                },
            },
            {
                extend: "pdfHtml5",
                exportOptions: {
                    columns: [0, 1, 2, 5],
                },
            },
            {
                extend: "colvis",
                postfixButtons: ["colvisRestore"],
                text: "Sembunyikan Kolom",
            },
        ],
    });
});

function getCode() {
    /* Get the text field */
    var copyText = document.getElementById("hardware_code");

    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /*For mobile devices*/

    /* Copy the text inside the text field */
    document.execCommand("copy");

    /* Alert the copied text */
    // alert("Copied the text: " + copyText.value);
    iziToast.success({
        title: "Informasi",
        icon: "fas fa-info",
        position: "topRight",
        message: "Kode Hardware Berhasil Di Salin",
    });
}
