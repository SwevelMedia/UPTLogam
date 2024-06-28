<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Halaman</a>
                </li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                    {{ ucfirst(request()->segment(1)) }}</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">
                @if (request()->segment(3) && !is_numeric(request()->segment(3)))
                    {{ ucfirst(request()->segment(3)) }}
                @elseif (is_numeric(request()->segment(2)))
                    Detail
                @elseif (is_numeric(request()->segment(3)))
                    {{ ucfirst(request()->segment(2)) }}
                @else
                    @if (ucfirst(request()->segment(2)) == 'Order')
                        Pesanan
                    @else
                        {{ ucfirst(request()->segment(2)) }}
                    @endif

                @endif
            </h6>

        </nav>
        <style>

        </style>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">

            </div>
            <ul class="navbar-nav  justify-content-end">

                <li class="nav-item dropdown d-flex align-items-center me-3">
                    <a href="javascript:;" class=" text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa fa-user me-sm-1 cursor-pointer"></i>
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                        aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="{{ url('profile/' . auth()->user()->id) }}">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        @if (auth()->user()->photo == url('/storage/image/profile'))
                                            <img src="{{ asset('storage/image/profile/user.png') }}"
                                                class="avatar avatar-sm  me-3 ">
                                        @else
                                            <img src="{{ auth()->user()->photo }}" class="avatar avatar-sm  me-3 ">
                                        @endif
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">{{ auth()->user()->name }}</span>
                                        </h6>
                                        <p class="text-xs text-secondary mb-0 ">
                                            {{ Auth::user()->email }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item d-flex justify-content-center">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger w-100">Log
                                    Out</button>
                            </form>
                        </li>
                    </ul>
                </li>


                {{-- @if (auth()->user()->role == 'programmer')
                    <li class="nav-item dropdown pe-2 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-bell {{ $count > 0 ? 'text-danger' : '' }} cursor-pointer"></i>
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                            aria-labelledby="dropdownMenuButton">
                            @if ($count > 0)
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1 ">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">{{ $count }} Pesanan
                                                        Baru</span>
                                                </h6>
                                                <p class="text-xs text-secondary mb-0 ">
                                                    <i class="fa fa-clock me-1"></i>
                                                    13 minutes ago
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @else --}}
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer"></i>
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                        aria-labelledby="dropdownMenuButton">
                        @php
                            function sortByUpdatedAtDescending($a, $b)
                            {
                                return strtotime($b['updated_at']) - strtotime($a['updated_at']);
                            }
                            $jumlah = 0;
                            $ON = array_merge($orderNotif->newNotif()->toArray());
                            if (auth()->user()->role == 'drafter') {
                                $ON = array_merge($orderNotif->acceptNotif()->toArray(), $revisiCad->toArray());
                                usort($ON, 'sortByUpdatedAtDescending');
                            } elseif (auth()->user()->role == 'programmer') {
                                $ON = array_merge($orderNotif->programmerNotif()->toArray(), $revisiCam->toArray());
                                usort($ON, 'sortByUpdatedAtDescending');
                            } elseif (auth()->user()->role == 'toolman') {
                                $ON = $orderNotif->toolmanNotif();
                            } elseif (auth()->user()->role == 'operator') {
                                $ON = $orderNotif->operatorNotif();
                            } elseif (auth()->user()->role == 'ppic') {
                                $ON = array_merge(
                                    $orderNotif->newNotif()->toArray(),
                                    $orderNotif->finishNotif()->toArray(),
                                    $notifCadAprov->toArray(),
                                    $notifCamAprov->toArray(),
                                );
                                usort($ON, 'sortByUpdatedAtDescending');
                            }
                        @endphp


                        @foreach ($ON as $notif)
                            @if (auth()->user()->role == 'operator' || auth()->user()->role == 'ppic' || auth()->user()->role == 'admin')
                                @php $jumlah++; @endphp
                                <li class="mb-2">
                                    @if ($notif['status'] == 5 || $notif['status'] == 7)
                                        <a class="dropdown-item border-radius-md"
                                            href="{{ url('/approve-desain/' . $notif['id']) }}">
                                    @elseif ($notif['status'] == 8)
                                        <a class="dropdown-item border-radius-md"
                                            href="{{ url('/approve-produksi/' . $notif['id']) }}">
                                        @else
                                            <a class="dropdown-item border-radius-md"
                                                href="{{ url('/order/' . $notif['id']) }}">
                                    @endif
                                    <div class="d-flex py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                @if ($notif['status'] == 5)
                                                    <span class="font-weight-bold">Approval CAD</span> pesanan
                                                    {{ $notif['order_name'] }}
                                                @elseif ($notif['status'] == 7)
                                                    <span class="font-weight-bold">Approval CAM</span> pesanan
                                                    {{ $notif['order_name'] }}
                                                @elseif ($notif['status'] == 8  && $notif['produksi'] == 2)
                                                    <span class="font-weight-bold text-success">Order Selesai</span> pesanan
                                                    {{ $notif['order_name'] }}
                                                @else
                                                    @foreach ($Client as $cl)
                                                        @if ($cl->id == $notif['client_id'])
                                                            <span class="font-weight-bold">Pesanan Baru</span> dari
                                                            {{ $cl->name }}
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </h6>
                                            <p class="text-xs text-secondary mb-0">
                                                <i class="fa fa-clock me-1"></i>
                                                <span class="timeDifference"
                                                    data-created-at="{{ $notif['updated_at'] }}"></span> yang lalu
                                            </p>
                                        </div>
                                    </div>
                                    </a>
                                </li>
                            @else
                                @foreach ($Schedule->Alls() as $schedule)
                                    @if ($schedule['order_number'] == $notif['order_number'] && $schedule['users_id'] == auth()->user()->id)
                                        <li class="mb-2">
                                            @if ($notif['cad_approv'] == 2)
                                                <a class="dropdown-item border-radius-md"
                                                    href="{{ url('/prog/revisi/' . $notif['id']) }}">
                                                @elseif ($notif['cam_approv'] == 2)
                                                    <a class="dropdown-item border-radius-md"
                                                        href="{{ url('/prog/revisi/' . $notif['id']) }}">
                                                    @else
                                                        <a class="dropdown-item border-radius-md"
                                                            href="{{ url('/order/' . $notif['id']) }}">
                                            @endif
                                            <div class="d-flex py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="text-sm font-weight-normal mb-1">
                                                        @if ($notif['cad_approv'] == 2)
                                                            <span class="font-weight-bold text-danger">Revisi CAD</span>
                                                            Pesanan {{ $notif['order_name'] }}
                                                        @elseif ($notif['cam_approv'] == 2)
                                                            <span class="font-weight-bold text-danger">Revisi CAM</span>
                                                            Pesanan {{ $notif['order_name'] }}
                                                        @else
                                                            @foreach ($Client as $cl)
                                                                @if ($cl->id == $notif['client_id'])
                                                                    <span class="font-weight-bold">Pesanan Baru</span>
                                                                    dari {{ $cl->name }}
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </h6>
                                                    <p class="text-xs text-secondary mb-0">
                                                        <i class="fa fa-clock me-1"></i>
                                                        <span class="timeDifference"
                                                            data-created-at="{{ $notif['updated_at'] }}"></span> yang
                                                        lalu
                                                    </p>
                                                </div>
                                            </div>
                                            </a>
                                        </li>
                                        @php $jumlah++; @endphp
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                        @if ($jumlah == 0)
                            <li class="mb-2">
                                <center>
                                    Tidak ada notif
                                </center>
                            </li>
                        @endif
                    </ul>
                    @if ($jumlah > 0)
                        <span class="badge-notif bg-danger notif-top"
                            style="font-size: 9px; padding-bottom: 10px; text-align: center; display: inline-block; height: 12px; width: 12px; line-height: 12px; margin: 0 0 9px -3px;">
                            {{ $jumlah }}
                        </span>
                    @endif



                </li>
                {{-- @endif --}}
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    // Ambil semua elemen dengan kelas CSS 'timeDifference'
    var timeDifferenceElements = document.querySelectorAll(".timeDifference");

    // Iterasi melalui setiap elemen dan hitung selisih waktu
    timeDifferenceElements.forEach(function(element) {
        var notificationTimeText = element.getAttribute("data-created-at");
        var notificationTime = new Date(notificationTimeText);
        var currentTime = new Date();
        var timeDifference = currentTime - notificationTime;
        var daysDifference = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
        var hoursDifference = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutesDifference = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
        var timeAgoString = "";

        // Jika sudah lebih dari 1 hari
        if (daysDifference > 0) {
            timeAgoString += daysDifference + " hari";
        }
        // Jika sudah lebih dari 1 jam
        else if (hoursDifference > 0) {
            timeAgoString += hoursDifference + " jam";
        }
        // Jika kurang dari 1 jam
        else {
            timeAgoString += minutesDifference + " menit";
        }

        // Tampilkan selisih waktu
        element.innerText = timeAgoString;
    });
    window.addEventListener('scroll', function() {
        var navbar = document.getElementById('navbarBlur');
        var scrollPosition = window.scrollY;

        if (scrollPosition > 0) {
            navbar.classList.add('navbar-fixed');
        } else {
            navbar.classList.remove('navbar-fixed');
        }
    });
</script>
