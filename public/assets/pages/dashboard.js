"use strict";

$("#hardware").on("click", function (e) {
    let hardware = $("#hardware_id").val();
    window.open("/print/" + hardware, "_blank");
});
