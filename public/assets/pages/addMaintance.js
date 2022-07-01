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

$("#addAdditional").click(function () {
    let count = Math.random().toString(36).substring(7);
    $.ajax({
        url: "/add-dependency/" + count,
        type: "GET",
        data: {
            code: count,
        },
        success: function (result) {
            $("#additional").append(result);
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
            $(".select2").select2();
            $("#maintenance_" + count).select2();
        },
    });
});

function getMaintenance(selectObject) {
    var value = selectObject.value;
    var id = selectObject.id.split("_")[1];
    $("#maintenance_" + id).html("");
    $.ajax({
        url: getMaintenanceUrl,
        type: "POST",
        data: {
            hardware_id: value,
        },
        dataType: "json",
        success: function (result) {
            $("#maintenance").html(
                '<option value="">PILIH KODE MAINTENANCE</option>'
            );
            $.each(result.data, function (key, value) {
                $("#maintenance_" + id).append(
                    '<option value="' +
                        value.id +
                        '">' +
                        value.code +
                        "</option>"
                );
            });
        },
    });
}
