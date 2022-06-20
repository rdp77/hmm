"use strict";

$("#addMTBF").click(function () {
    $("#mtbf").append(
        '<div class="row"><div class="col"><div class="form-group">' +
            '<label class="control-label">Waktu Kerusakan<code>*</code></label>' +
            '<div class="input-group mb-2"><input type="text" class="form-control text-right" name="time_damaged[]" required>' +
            '<div class="input-group-append">' +
            '<div class="input-group-text">Jam</div></div></div></div></div>' +
            '<div class="col"><div class="form-group"><label>Waktu Mulai Kerusakan</label><div class="input-group">' +
            '<div class="input-group-prepend"><div class="input-group-text"> <i class="fas fa-clock"></i></div>' +
            '</div><input type="text" class="form-control timepicker" name="start_damaged[]"></div></div></div></div>'
    );
    $(".timepicker").timepicker({
        icons: {
            up: "fas fa-chevron-up",
            down: "fas fa-chevron-down",
        },
        showSeconds: false,
        showMeridian: false,
    });
});

$("#addMTTR").click(function () {
    $("#mttr").append(
        '<div class="row"><div class="col"> <div class="form-group"> <label class="control-label">Total Maintenance<code>*</code>' +
            '</label> <div class="input-group mb-2"> <input type="text" class="form-control text-right" name="total_maintenance[]" required> <div class="input-group-append">' +
            '<div class="input-group-text">Jam</div></div></div></div></div><div class="col"> <div class="form-group"> <label>Waktu Maintenance</label>' +
            '<div class="input-group"> <div class="input-group-prepend"> <div class="input-group-text"> <i class="fas fa-clock"></i> </div></div>' +
            '<input type="text" class="form-control timepicker" name="time_maintenance[]"> </div></div></div></div>'
    );
    $(".timepicker").timepicker({
        icons: {
            up: "fas fa-chevron-up",
            down: "fas fa-chevron-down",
        },
        showSeconds: false,
        showMeridian: false,
    });
});
