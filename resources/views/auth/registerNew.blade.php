<!--
=========================================================
* Soft UI Dashboard - v1.0.7
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2023 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/UPT.ico') }}">
    <title>
        UPT Logam
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.7" rel="stylesheet" />
</head>

<body class=" ">
    <section>
        <div class="container min-vh-80">
            <div class="row">

                <div class="d-flex justify-content-center mt-5">
                    <img src="{{ asset('assets/img/UPT.ico') }}">
                </div>

                <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="font-weight-bolder h2 mb-3 text-center text-info text-gradient">Sign Up</h3>
                            @if ($errors->any())
                            <div class="my-3">
                                <div class="alert text-white alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif
                            <form method="POST" action="{{ url('register') }}">
                                @csrf
                                <label>Nama</label>
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="nama" aria-label="name"
                                        aria-describedby="name-addon" name="name">
                                </div>
                                <label>NIP</label>
                                <div class="mb-3">
                                    <input type="number" class="form-control" placeholder="NIP" aria-label="nip"
                                        aria-describedby="nip-addon" name="nip">
                                </div>
                                <div class="mb-3">
                                    <label for="role">Role</label>
                                    <select id="role" class="form-control" name=" role" required autofocus
                                        autocomplete="role" style="background-color: transparent;" required>
                                        <option value="" class="text-da">Select Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="ppic">PPIC</option>
                                        <option value="programmer">Programmer</option>
                                        <option value="toolman">Tools Man</option>
                                        <option value="operator">Operator</option>
                                    </select>
                                    <?php if ($errors->has('role')) : ?>
                                    <span class="mt-2 text-danger"><?php echo $errors->first('role'); ?></span>
                                    <?php endif; ?>
                                </div>

                                <label>Email</label>
                                <div class="mb-3">
                                    <input type="email" class="form-control" placeholder="Email" aria-label="Email"
                                        aria-describedby="email-addon" name="email">
                                </div>
                                <label>Password</label>
                                <div class="mb-3">
                                    <input type="password" class="form-control" placeholder="Confirm Password"
                                        aria-label="Password" aria-describedby="password-addon" name="password">
                                </div>
                                <label>Confirm Password</label>
                                <div class="mb-3">
                                    <input type="password" class="form-control" placeholder="Password"
                                        aria-label="password_confirmation"
                                        aria-describedby="password_confirmation-addon" name="password_confirmation">
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="rememberMe" checked="">
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign Up
                                    </button>
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
                    <p class="mb-0 text-secondary">
                        ERP UPT Logam v.0
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->

</body>

</html>