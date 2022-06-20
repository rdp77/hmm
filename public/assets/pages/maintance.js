"use strict";

var table = $("#table").DataTable({
    pageLength: 10,
    processing: true,
    serverSide: true,
    responsive: true,
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, "Semua"],
    ],
    ajax: {
        url: index,
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

var statistics_chart = document.getElementById("uptime").getContext("2d");

var uptime = new Chart(statistics_chart, {
    type: "line",
    data: {
        labels: [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember",
        ],
        datasets: [
            {
                label: "Uptime",
                data: [55, 20, 30, 31, 100, 99, 92, 85, 92, 50, 40, 90],
                borderWidth: 5,
                borderColor: "#6777ef",
                backgroundColor: "transparent",
                pointBackgroundColor: "#fff",
                pointBorderColor: "#6777ef",
                pointRadius: 4,
            },
        ],
    },
    options: {
        legend: {
            display: false,
        },
        scales: {
            yAxes: [
                {
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        stepSize: 25,
                        callback: function (value, index, values) {
                            return value + "%";
                        },
                    },
                },
            ],
            xAxes: [
                {
                    gridLines: {
                        color: "#fbfbfb",
                        lineWidth: 2,
                    },
                },
            ],
        },
    },
});

var ctx = document.getElementById("maintenance").getContext("2d");
var maintenance = new Chart(ctx, {
    type: "line",
    data: {
        labels: [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember",
        ],
        datasets: [
            {
                label: "MTBF",
                data: [
                    460, 458, 330, 502, 430, 610, 488, 568, 568, 568, 568, 568,
                ],
                borderWidth: 2,
                backgroundColor: "rgba(63,82,227,.8)",
                borderWidth: 0,
                borderColor: "transparent",
                pointBorderWidth: 0,
                pointRadius: 3.5,
                pointBackgroundColor: "transparent",
                pointHoverBackgroundColor: "rgba(63,82,227,.8)",
            },
            {
                label: "MTTR",
                data: [
                    390, 600, 390, 280, 600, 430, 638, 488, 568, 568, 568, 568,
                    568,
                ],
                borderWidth: 2,
                backgroundColor: "rgba(254,86,83,.7)",
                borderWidth: 0,
                borderColor: "transparent",
                pointBorderWidth: 0,
                pointRadius: 3.5,
                pointBackgroundColor: "transparent",
                pointHoverBackgroundColor: "rgba(254,86,83,.8)",
            },
        ],
    },
    options: {
        legend: {
            display: true,
        },
        scales: {
            yAxes: [
                {
                    gridLines: {
                        drawBorder: false,
                        color: "#f2f2f2",
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: 120,
                        callback: function (value, index, values) {
                            return value + " Jam";
                        },
                    },
                },
            ],
            xAxes: [
                {
                    gridLines: {
                        display: false,
                        tickMarkLength: 15,
                    },
                },
            ],
        },
    },
});
