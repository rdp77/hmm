$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

function submitForm(data) {
    $.ajax({
        type: "GET",
        url: url,
        data: data,
        success: function (result) {
            console.log(result);
            // redirect to slug code
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
