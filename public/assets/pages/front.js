$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

function submitForm(code) {
    $.ajax({
        type: "GET",
        url: "/search/" + code,
        code: code,
        success: function (result) {
            swal({
                title: "Kode Hardware Ditemukan!",
                icon: "success",
            }).then(function () {
                window.location = result.url;
            });
        },
        statusCode: {
            404: function (response) {
                iziToast.error({
                    title: "Error",
                    message: response.responseJSON.data,
                });
            },
        },
    });
    return false;
}

$("#submit").on("keyup", function () {
    if (this.value.length == 10) {
        submitForm(this.value);
    }
});

function onScanSuccess(decodedText, decodedResult) {
    submitForm(decodedText);
}

function onScanFailure(error) {
    console.warn(`Code scan error = ${error}`);
}

let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    { fps: 10, qrbox: { width: 250, height: 250 } },
    /* verbose= */ false
);

html5QrcodeScanner.render(onScanSuccess, onScanFailure);
