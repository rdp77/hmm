"use strict";

$("#addMTBF").click(function () {
    $("#mtbf").append(
        '<div class="row"><div class="col"><div class="form-group">' +
            '<label class="control-label">Waktu Kerusakan<code>*</code></label>' +
            '<div class="input-group mb-2"><input type="text" class="form-control text-right" name="breakdown[]" required>' +
            '<div class="input-group-append">' +
            '<div class="input-group-text">Jam</div></div></div></div></div>' +
            '<div class="col"><div class="form-group"><label>Waktu Mulai Kerusakan</label><div class="input-group">' +
            '<div class="input-group-prepend"><div class="input-group-text"> <i class="fas fa-clock"></i></div>' +
            '</div><input type="text" class="form-control timepicker" name="time_breakdown[]"></div></div></div></div>'
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
            '</label> <div class="input-group mb-2"> <input type="text" class="form-control text-right" name="maintenance_time[]" required> <div class="input-group-append">' +
            '<div class="input-group-text">Jam</div></div></div></div></div><div class="col"> <div class="form-group"> <label>Waktu Maintenance</label>' +
            '<div class="input-group"> <div class="input-group-prepend"> <div class="input-group-text"> <i class="fas fa-clock"></i> </div></div>' +
            '<input type="text" class="form-control timepicker" name="start_time[]"> </div></div></div></div>'
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

function removeCard(index) {
    $("#mycard" + index).remove();
}

let count = 0;
$("#addAdditional").click(function () {
    count++;
    $("#additional").append(
        '<div class="card" id="mycard' +
            count +
            '"><div class="card-header"><h4>Data Maintenance Tambahan ' +
            '</h4><div class="card-header-action">' +
            '<a class="btn btn-icon btn-danger" href="#" data-dismiss="#mycard' +
            count +
            '"><i class="fas fa-times"></i></a>' +
            '</div></div><div class="card-body">' +
            count +
            "</div></div>"
    );
    $("[data-dismiss]").each(function () {
        var me = $(this),
            target = me.data("dismiss");

        me.click(function () {
            $(target).fadeOut(function () {
                $(target).remove();
            });
            return false;
        });
    });
});

$("#hardware_1").on("change", function () {
    var hardwareId = this.value;
    $("#maintenance").html("");
    $.ajax({
        url: getMaintenanceUrl,
        type: "POST",
        data: {
            hardware_id: hardwareId,
        },
        dataType: "json",
        success: function (result) {
            $("#maintenance").html(
                '<option value="">PILIH KODE MAINTENANCE</option>'
            );
            $.each(result.data, function (key, value) {
                $("#maintenance").append(
                    '<option value="' +
                        value.id +
                        '">' +
                        value.code +
                        "</option>"
                );
            });
        },
    });
});
