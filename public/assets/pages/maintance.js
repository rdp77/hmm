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

var statistics_chart = document.getElementById("myChart").getContext("2d");

var myChart = new Chart(statistics_chart, {
    type: "line",
    data: {
        labels: [
            "Sunday",
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
        ],
        datasets: [
            {
                label: "Statistics",
                data: [640, 387, 530, 302, 430, 270, 488],
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
                        stepSize: 150,
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

var ctx = document.getElementById("myCharts").getContext("2d");
var myCharts = new Chart(ctx, {
    type: "line",
    data: {
        labels: [
            "Sunday",
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
        ],
        datasets: [
            {
                label: "Statistics",
                data: [460, 458, 330, 502, 430, 610, 488],
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
                label: "Statistics",
                data: [390, 600, 390, 280, 600, 430, 638],
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
            display: false,
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
                        stepSize: 200,
                        callback: function (value, index, values) {
                            return "$" + value;
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

var ctx = document.getElementById("myChart2").getContext("2d");
var myChart = new Chart(ctx, {
    type: "bar",
    data: {
        labels: [
            "Sunday",
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
        ],
        datasets: [
            {
                label: "Statistics",
                data: [460, 458, 330, 502, 430, 610, 488],
                borderWidth: 2,
                backgroundColor: "rgba(254,86,83,.7)",
                borderColor: "rgba(254,86,83,.7)",
                borderWidth: 2.5,
                pointBackgroundColor: "#ffffff",
                pointRadius: 4,
            },
            {
                label: "Statistics",
                data: [550, 558, 390, 562, 490, 670, 538],
                borderWidth: 2,
                backgroundColor: "rgba(63,82,227,.8)",
                borderColor: "transparent",
                borderWidth: 0,
                pointBackgroundColor: "#999",
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
                        drawBorder: false,
                        color: "#f2f2f2",
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: 150,
                    },
                },
            ],
            xAxes: [
                {
                    gridLines: {
                        display: false,
                    },
                },
            ],
        },
    },
});

var ctx = document.getElementById("myChart3").getContext("2d");
var myChart = new Chart(ctx, {
    type: "line",
    data: {
        labels: [
            "Sunday",
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
        ],
        datasets: [
            {
                label: "Google",
                data: [290, 358, 220, 402, 690, 510, 688],
                borderWidth: 2,
                backgroundColor: "transparent",
                borderColor: "rgba(254,86,83,.7)",
                borderWidth: 2.5,
                pointBackgroundColor: "transparent",
                pointBorderColor: "transparent",
                pointRadius: 4,
            },
            {
                label: "Facebook",
                data: [450, 258, 390, 162, 440, 570, 438],
                borderWidth: 2,
                backgroundColor: "transparent",
                borderColor: "rgba(63,82,227,.8)",
                borderWidth: 0,
                pointBackgroundColor: "transparent",
                pointBorderColor: "transparent",
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
                        drawBorder: false,
                        color: "#f2f2f2",
                    },
                    ticks: {
                        beginAtZero: true,
                        stepSize: 200,
                    },
                },
            ],
            xAxes: [
                {
                    gridLines: {
                        display: false,
                    },
                },
            ],
        },
    },
});

$("#visitorMap").vectorMap({
    map: "world_en",
    backgroundColor: "#ffffff",
    borderColor: "#f2f2f2",
    borderOpacity: 0.8,
    borderWidth: 1,
    hoverColor: "#000",
    hoverOpacity: 0.8,
    color: "#ddd",
    normalizeFunction: "linear",
    selectedRegions: false,
    showTooltip: true,
    pins: {
        id: '<div class="jqvmap-circle"></div>',
        my: '<div class="jqvmap-circle"></div>',
        th: '<div class="jqvmap-circle"></div>',
        sy: '<div class="jqvmap-circle"></div>',
        eg: '<div class="jqvmap-circle"></div>',
        ae: '<div class="jqvmap-circle"></div>',
        nz: '<div class="jqvmap-circle"></div>',
        tl: '<div class="jqvmap-circle"></div>',
        ng: '<div class="jqvmap-circle"></div>',
        si: '<div class="jqvmap-circle"></div>',
        pa: '<div class="jqvmap-circle"></div>',
        au: '<div class="jqvmap-circle"></div>',
        ca: '<div class="jqvmap-circle"></div>',
        tr: '<div class="jqvmap-circle"></div>',
    },
});
