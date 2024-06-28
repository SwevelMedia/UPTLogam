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
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.7') }}" rel="stylesheet" />
    <!-- Nepcha Analytics (nepcha.com) -->
    <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
    <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>

    <link rel="stylesheet" href="{{ asset('assets/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/select2/select2-bootstrap4.css') }}">
    <link id="pagestyle" href="{{ asset('assets/css/icon-status.css') }}" rel="stylesheet" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid justify-content-between d-flex">
            <a class="navbar-brand" href="#" style="border-radius: 100px; overflow: hidden;"><img
                    src="{{ asset('assets/img/uptlogam.png') }}"
                    style="border-radius: 5px; overflow: hidden; height:50px"></a>


            <a href="{{ url('/cek-status') }}" class="btn bg-gradient-primary text-white my-4 mb-2">Cek
                Status</a>

        </div>
    </nav>
    <main class="main-content  mt-0">
        <section class="min-vh-100 mb-8">
            <div class="page-header align-items-start min-vh-5 pt-5 pb-11 m-3 border-radius-lg"
                style="background-image: url('../assets/img/curved-images/curved14.jpg');">
                <span class="mask bg-gradient-dark opacity-6"></span>
                <div class="container">
                    <div class="row justify-content-center">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row mt-lg-n10 mt-md-n11 mt-n10">
                    <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                        <div class="card z-index-0 bt-primary">
                            <div class="card-header text-center pt-3">
                                <h5>Form Pemesanan</h5>
                                <h6>UPT Logam</h6>
                            </div>
                            <div class="swal" data-swal="{{ session('success') }}"></div>
                            @if ($errors->any())
                                <div class="my-3">
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                            <div class="row px-xl-5 px-sm-4 px-3">
                                <div class="mt-1 position-relative text-center">
                                </div>
                            </div>
                            <div class="card-body">

                                <form role="form" method="POST" action="{{ route('client.order') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="text" id="perusahaan" name="perusahaan" class="form-control"
                                            placeholder="Nama Client" aria-label="Name Perusahaan"
                                            aria-describedby="name-perusahaan-addon" required list="perusahaan-list"
                                            autocomplete="off">
                                    </div>

                                    <datalist id="perusahaan-list">
                                        @foreach ($data as $index)
                                            @if ($index->name)
                                                <option value="{{ $index->name }}" data-phone="{{ $index->phone }}"
                                                    data-address="{{ $index->address }}">
                                            @endif
                                        @endforeach
                                    </datalist>

                                    <div class="mb-3">
                                        <input type="text" id="phone" name="phone" class="form-control"
                                            placeholder="Nomor Telepon" aria-label="Phone"
                                            aria-describedby="phone-addon" required>
                                    </div>

                                    <div class="mb-3">
                                        <input type="text" id="address" name="address" class="form-control"
                                            placeholder="Alamat Client" aria-label="Address"
                                            aria-describedby="address-addon" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" id="order_name" name="order_name" class="form-control"
                                            placeholder="Nama Proyek" aria-label="Order Name"
                                            aria-describedby="name-project-addon" required>
                                    </div>
                                    <div class="mb-3">
                                        <select name="material" id="material" class="form-select" required>
                                            <option value="" hidden>Pilih Material</option>
                                            @foreach ($material as $mat)
                                                <option value="{{ $mat->name }}">{{ $mat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <input type="file" name="gambar[]" class="form-control"
                                            placeholder="Gambar" aria-label="Gambar" aria-describedby="gambar-addon"
                                            multiple>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit"
                                            class="btn bg-gradient-primary text-white w-100 my-4 mb-0">Simpan</button>
                                    </div>
                                </form>
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
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="{{ asset('assets/select2/select2.min.js') }}"></script>
    <script>
        $('#material').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
    </script>
    <script>
        const swal = $('.swal').data('swal');
        if (swal) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: swal,

            })
        }
    </script>
    <script type="text/javascript">
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $(document).ready(function() {
            $('#perusahaan').on('input', function() {
                var perusahaan = $(this).val();
                $.ajax({
                    url: '/autofill', // Ganti dengan URL yang sesuai dengan route di Laravel Anda
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'perusahaan': perusahaan
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#phone').val(response.data.phone);
                            $('#address').val(response.data.address);
                            $('#order_name').val(response.data.order_name);
                            $('#material').val(response.data.material);
                            // Anda dapat menambahkan autofill untuk data lain di sini
                        } else {
                            // Reset input fields if client not found
                            $('#phone').val('');
                            $('#address').val('');
                            $('#order_name').val('');
                            $('#material').val('');
                            // Reset input fields for other autofilled data here
                        }
                    }
                });
            });
        });
    </script>
    <script>
        document.getElementById("perusahaan").addEventListener("input", function() {
            var input = this.value.toLowerCase();
            var suggestions = document.getElementById("suggestions");
            suggestions.innerHTML = "";

            var dataNames = document.getElementsByClassName("data-name");
            for (var i = 0; i < dataNames.length; i++) {
                var name = dataNames[i].textContent.toLowerCase();
                if (name.includes(input)) {
                    var suggestion = document.createElement("div");
                    suggestion.textContent = dataNames[i].textContent;
                    suggestion.className = "suggestion";
                    suggestion.addEventListener("click", function() {
                        document.getElementById("perusahaan").value = this.textContent;
                        suggestions.innerHTML = "";
                    });
                    suggestions.appendChild(suggestion);
                }
            }
        });
    </script>
    <script>
        document.getElementById("perusahaan").addEventListener("input", function() {
            var selectedOption = document.querySelector("#perusahaan-list option[value='" + this.value + "']");
            if (selectedOption) {
                var phone = selectedOption.getAttribute("data-phone");
                var address = selectedOption.getAttribute("data-address");
                document.getElementById("phone").value = phone;
                document.getElementById("address").value = address;
            }
        });
        document.getElementById("material").addEventListener("input", function() {
            var selectedOption = document.querySelector("#material-list option[value='" + this.value + "']");
            if (selectedOption) {
                // You can add additional logic here if needed
            }
        });
    </script>



</body>

</html>
