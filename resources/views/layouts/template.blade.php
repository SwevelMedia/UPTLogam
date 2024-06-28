<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/ico" href="{{ asset('assets/img/UPT.ico') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>
        UPT Logam
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.7') }}" rel="stylesheet" />

    @stack('css')
</head>

<body class="g-sidenav-show  bg-gray-100">
    @php
        use App\Models\Order;
        use App\Models\Schedule;
        use App\Models\Client;
        $orderNotif = new Order();
        $Schedule = new Schedule();
        $Client = Client::get();
        $notifCadAprov = Order::Where('status', 5)->where('cad_approv', 0)->get();
        $notifCamAprov = Order::Where('status', 7)->where('cam_approv', 0)->get();

        $revisiCad = Order::Where('status', 5)->where('cad_approv', 2)->get();
        $revisiCam = Order::Where('status', 7)->where('cam_approv', 2)->get();
    @endphp
    @include('layouts.sidenav')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @include('layouts.topnav')
        <div class="container-fluid py-4">
            <div style="min-height: 75vh">
                @yield('content')
            </div>

            @include('layouts.footer')
        </div>
    </main>

    <div class="fixed-plugin">
        <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
            <i class="fa fa-cog py-2"> </i>
        </a>
        <div class="card shadow-lg ">
            <div class="card-header pb-0 pt-3 ">
                <div class="float-start">
                    <h5 class="mt-3 mb-0">Soft UI Configurator</h5>
                    <p>See our dashboard options.</p>
                </div>
                <div class="float-end mt-4">
                    <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
                <!-- End Toggle Button -->
            </div>
            <hr class="horizontal dark my-1">
            <div class="card-body pt-sm-3 pt-0">
                <!-- Sidebar Backgrounds -->
                <div>
                    <h6 class="mb-0">Sidebar Colors</h6>
                </div>
                <a href="javascript:void(0)" class="switch-trigger background-color">
                    <div class="badge-colors my-2 text-start">
                        <span class="badge filter bg-gradient-primary active" data-color="primary"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-dark" data-color="dark"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-info" data-color="info"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-success" data-color="success"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-warning" data-color="warning"
                            onclick="sidebarColor(this)"></span>
                        <span class="badge filter bg-gradient-danger" data-color="danger"
                            onclick="sidebarColor(this)"></span>
                    </div>
                </a>
                <!-- Sidenav Type -->
                <div class="mt-3">
                    <h6 class="mb-0">Sidenav Type</h6>
                    <p class="text-sm">Choose between 2 different sidenav types.</p>
                </div>
                <div class="d-flex">
                    <button class="btn bg-gradient-primary w-100 px-3 mb-2 active" data-class="bg-transparent"
                        onclick="sidebarType(this)">Transparent</button>
                    <button class="btn bg-gradient-primary w-100 px-3 mb-2 ms-2" data-class="bg-white"
                        onclick="sidebarType(this)">White</button>
                </div>
                <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
                <!-- Navbar Fixed -->
                <div class="mt-3">
                    <h6 class="mb-0">Navbar Fixed</h6>
                </div>
                <div class="form-check form-switch ps-0">
                    <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed"
                        onclick="navbarFixed(this)">
                </div>
                <hr class="horizontal dark my-sm-4">
                <a class="btn bg-gradient-dark w-100" href="https://www.creative-tim.com/product/soft-ui-dashboard">Free
                    Download</a>
                <a class="btn btn-outline-dark w-100"
                    href="https://www.creative-tim.com/learning-lab/bootstrap/license/soft-ui-dashboard">View
                    documentation</a>
                <div class="w-100 text-center">
                    <a class="github-button" href="https://github.com/creativetimofficial/soft-ui-dashboard"
                        data-icon="octicon-star" data-size="large" data-show-count="true"
                        aria-label="Star creativetimofficial/soft-ui-dashboard on GitHub">Star</a>
                    <h6 class="mt-3">Thank you for sharing!</h6>
                    <a href="https://twitter.com/intent/tweet?text=Check%20Soft%20UI%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fsoft-ui-dashboard"
                        class="btn btn-dark mb-0 me-2" target="_blank">
                        <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/soft-ui-dashboard"
                        class="btn btn-dark mb-0 me-2" target="_blank">
                        <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed-plugin">
        <a href="{{ url('/scan') }}" class="fixed-plugin-button text-dark position-fixed px-3 py-2">
            <i class="fas fa-solid fa-camera text-dark"></i>
        </a>
    </div>
    {{-- <div class="fixed-plugin">
        <a href="#" data-bs-toggle="modal" data-bs-target="#scan"
            class="fixed-plugin-button text-dark position-fixed px-3 py-2">
            <i class="fas fa-solid fa-camera text-dark"></i>
        </a>
    </div>

    <div class="modal fade" id="scan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div style="text-align: center; position: relative; height: 570px">
                        <div id="imgscan">
                            <img src="{{ asset('assets/img/scanblue.png') }}"alt="" class="img-fluid img-small">
                        </div>
                        <div id="reader" class="centered-content w-xl-50 w-lg-50 w-md-70 w-sm-80 border border-0 "
                            style="position: absolute; top: -430px; left: 0;">

                        </div>
                    </div>
                </div>

            </div>
        </div> --}}
    </div>

    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets/js/soft-ui-dashboard.js') }}"></script>
    @stack('js')


    {{-- <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var reader = document.getElementById("reader");

            reader.addEventListener("click", function() {
                document.getElementById("imgscan").style.display = "none";
                reader.style.top = "0px";
            });

            var ButtonStop = "p";
            setInterval(function() {
                var Stop = document.getElementById("html5-qrcode-button-camera-stop");
                if (Stop) {
                    ButtonStop = Stop.innerHTML;
                }
            }, 1000); //

            ButtonStop.addEventListener("click", function() {
                document.getElementById("imgscan").style.display = "block";
                document.getElementById("reader").style.top = "-430px";
            });
        });

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

                    false);
                html5QrcodeScanner.render(onScanSuccess, onScanFailure);
            }
        }


        $(document).ready(function() {
            startScan();
        });

        function onScanSuccess(decodedText, decodedResult) {
            if (!isScanSuccessful) {
                var orderNumber = decodedText;

                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                var form = document.createElement("form");
                form.setAttribute("method", "post");
                form.setAttribute("action", "{{ url('scan/attempt') }}");
                form.setAttribute("style", "display: none;");

                var inputOrderNumber = document.createElement("input");
                inputOrderNumber.setAttribute("type", "hidden");
                inputOrderNumber.setAttribute("name", "order_number");
                inputOrderNumber.setAttribute("value", orderNumber);
                form.appendChild(inputOrderNumber);

                var csrfInput = document.createElement("input");
                csrfInput.setAttribute("type", "hidden");
                csrfInput.setAttribute("name", "_token");
                csrfInput.setAttribute("value", csrfToken);
                form.appendChild(csrfInput);

                document.body.appendChild(form);

                form.submit();

                isScanSuccessful = true;
            }
        }


        function onScanFailure(error) {

        }
    </script> --}}
</body>

</html>
