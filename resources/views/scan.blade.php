@extends('layouts.template')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link id="pagestyle" href="{{ asset('assets/css/icon-status.css')}}" rel="stylesheet" />
@endpush

@section('content')
<div class="card mb-4">
    <div class="container my-5 h-100">
        <div style="text-align: center; position: relative; height: 570px">
            <div id="imgscan">
                <img  src="{{ asset('assets/img/scanblue.png')}}"alt="" class="img-fluid img-small" >
            </div>
            <div id="reader" class="centered-content w-xl-50 w-lg-50 w-md-70 w-sm-80 border border-0 " style="position: absolute; top: -430px; left: 0;">
                <!-- Konten elemen reader di sini -->
            </div>
        </div>

    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>

document.addEventListener("DOMContentLoaded", function() {
  var reader = document.getElementById("reader");

  reader.addEventListener("click", function() {
    document.getElementById("imgscan").style.display = "none";
    reader.style.top = "0px";
  });

  var ButtonStop = document.getElementById("imgscan"); // Apakah ini diperlukan?
setInterval(function() {
    var Stop = document.getElementById("html5-qrcode-button-camera-stop");
    if (Stop && Stop.disabled) {
        document.getElementById("imgscan").style.display = "block";
        document.getElementById("reader").style.top = "-430px";
    } else if(Stop && !Stop.disabled){
        document.getElementById("imgscan").style.display = "none";
        reader.style.top = "0px";
    }
    // else {
    //     console.log("memek aji")
    //     document.getElementById("imgscan").style.display = "block";
    //     document.getElementById("reader").style.top = "-430px";
    // }
    // console.log(Stop)
}, 1000);// 1000 milliseconds = 1 detik

});



// Variabel global untuk melacak status pemindaian
let isScanSuccessful = false;

function startScan() {
    if (!isScanSuccessful) {
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: {
                    width: 400,
                    height: 400
                }
            },
            /* verbose= */
            false);
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    }
}


$(document).ready(function() {
    startScan();
});

function onScanSuccess(decodedText, decodedResult) {
    if (!isScanSuccessful) {
        var orderNumber = decodedText; // Mendapatkan nilai order_number dari decodedText

        // Mendapatkan token CSRF
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Membuat formulir dinamis untuk mengirimkan data order_number melalui metode POST
        var form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "{{ url('scan/attempt') }}");
        form.setAttribute("style", "display: none;"); // Form tidak akan ditampilkan kepada pengguna

        // Menambahkan input order_number ke dalam formulir
        var inputOrderNumber = document.createElement("input");
        inputOrderNumber.setAttribute("type", "hidden");
        inputOrderNumber.setAttribute("name", "order_number");
        inputOrderNumber.setAttribute("value", orderNumber);
        form.appendChild(inputOrderNumber);

        // Menambahkan token CSRF ke dalam header
        var csrfInput = document.createElement("input");
        csrfInput.setAttribute("type", "hidden");
        csrfInput.setAttribute("name", "_token");
        csrfInput.setAttribute("value", csrfToken);
        form.appendChild(csrfInput);

        // Menambahkan formulir ke dalam body dokumen
        document.body.appendChild(form);

        // Melakukan submit form secara otomatis
        form.submit();

        // Set isScanSuccessful menjadi true
        isScanSuccessful = true;
    }
}


// function onScanSuccess(decodedText, decodedResult) {
//     // var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
//     // $.ajax({
//     //     url: "/scan/attempt",
//     //     method: "POST",
    //     headers: {
    //         'X-CSRF-TOKEN': csrfToken // Menambahkan token CSRF ke dalam header
    //     },
//     //     data: {
//     //         order_number: orderNumber,
//     //         scanned_text: decodedText
//     //     },
//     //     success: function(response) {
//     //         Swal.fire({
//     //             title: 'Success',
//     //             text: response.message,
//     //             icon: 'success'
//     //         }).then((result) => {
//     //             window.location.href = '/prog/order/' + id
//     //         })
//     //     },
//     //     error: function(xhr, ajaxOption, thrownError) {
//     //         alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
//     //     }
//     // });
//     console.log(`Scan result: ${decodedText}`, decodedResult);
//     // ...
//     html5QrcodeScanner.clear();
// }

function onScanFailure(error) {
    // console.warn(`Code scan error = ${error}`);
}
</script>
@endpush
