"use strict";

$("#datePurchase").click(function () {
    let purchase = $("[name=purchase_date]");
    purchase.val("");
});

$("#dateWarranty").click(function () {
    let warranty = $("[name=warranty_date]");
    warranty.val("");
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

function getSerial() {
    /* Get the text field */
    var copyText = document.getElementById("serial_number");

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
        message: "Serial Number Berhasil Di Salin",
    });
}
