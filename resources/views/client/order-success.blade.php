<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/ico" href="{{ asset('assets/img/UPT.ico') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <title>
        UPT Logam | Pemesanan
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.7') }}" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('assets/css/icon-status.css') }}" rel="stylesheet" />
    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid justify-content-between d-flex">
            <a class="navbar-brand" href="#" style="border-radius: 100px; overflow: hidden;"><img
                    src="{{ asset('assets/img/uptlogam.png') }}"
                    style="border-radius: 5px; overflow: hidden; height:50px"></a>
        </div>
    </nav>
    <main class="main-content  mt-0">
        <section class="min-vh-100 mb-8">
            <div class="page-header align-items-start min-vh-5 pt-5 pb-11 m-3 border-radius-lg"
                style="background-image: url('{{ asset('assets/img/curved-images/curved14.jpg') }}');">
                <span class="mask bg-gradient-dark opacity-6"></span>
                <div class="container">
                    <div class="row justify-content-center">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row mt-lg-n10 mt-md-n11 mt-n10">
                    <div class="col-md-6 mx-auto">
                        <div class="card z-index-0">

                            <div class="card-body ">
                                <img class="img-fluid mx-auto d-block" src="{{ asset('images/ordersuccess.jpg') }}"
                                    alt="">
                                <p class="h4 text-center mb-3">Terima Kasih! Pesanan Sedang Diproses</p>
                                <div class="px-sm-4">
                                    <table class="table">
                                        <tr>
                                            <td>Nama Client</td>
                                            <td>: {{ $order->client->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama Proyek</td>
                                            <td>: {{ $order->order_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nomor Pesanan</td>
                                            <td>
                                                : <span id="orderNumber" class="me-2">{{ $order->order_number }}</span>
                                                <i id="copyIcon" class="fa-regular fa-copy"
                                                    style="cursor: pointer;"></i>
                                            </td>
                                        </tr>
                                    </table>
                                    <p class="px-sm-2 mb-0">
                                        Gunakan Nomor Pesanan Untuk Melihat Status Pesanan
                                    </p>
                                    <div class="row justify-content-center">
                                        <a href="{{ url('/cek-status') }}"
                                            class="btn bg-gradient-primary text-white my-4 mb-2">Cek
                                            Status</a>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
        <footer class="footer py-5">
            <div class="container">
                <div class="row">
                    <div class="col-8 mx-auto text-center mt-1">
                        <p class="mb-0 text-sm text-muted">
                            © dibuat oleh
                            <a href="https://beecons.co.id/" class="font-weight-bold" target="_blank">PT Baracipta
                                Esa
                                Engineering
                            </a>
                            <script>
                            document.write(new Date().getFullYear())
                            </script>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
    </main>
    <!--   Core JS Files   -->
    <script src="../assets/js/core/popper.min.js"></script>
    <script src="../assets/js/core/bootstrap.min.js"></script>
    <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
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
    <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

    <script>
    document.getElementById('copyIcon').addEventListener('click', function() {
        // Mengambil nilai nomor pesanan
        var orderNumber = document.getElementById('orderNumber').innerText.trim();

        // Membuat textarea sementara untuk menyalin teks
        var textarea = document.createElement('textarea');
        textarea.value = orderNumber;
        document.body.appendChild(textarea);

        // Memilih teks dalam textarea
        textarea.select();
        textarea.setSelectionRange(0, 99999); // Untuk mendukung mobile

        // Menyalin teks ke clipboard
        document.execCommand('copy');

        // Menghapus textarea sementara
        document.body.removeChild(textarea);

        // Memberi umpan balik bahwa teks telah disalin
        alert('Nomor pesanan telah disalin: ' + orderNumber);
    });
    </script>

</body>

</html>
