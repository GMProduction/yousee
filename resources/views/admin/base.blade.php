<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Skripsi || Admin</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/appstyle/genosstyle.1.0.css') }}" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- <link rel="stylesheet"
        href="https://fonts.sandbox.google.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" /> --}}

    {{-- ICON --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('datatable/datatables.min.css') }}"/>
    <link href="{{ asset('css/dropify/css/dropify.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="{{ asset('js/swal.js') }}"></script>

    @yield('css')
</head>

<body>

<div class="header">
    <div class="header-panel-kiri">
        <a class="btn-icon " onclick="openNav()">
                <span class="material-icons">menu
                </span>
        </a>

        <p class="title">
            Nama Perusahaan
        </p>
    </div>

    <p class="text-title text-center">
        Beranda
    </p>

    <div class="header-panel-kanan">
        <a class="profil dropdown-toggle" href="#" role="button" id="dropdownprofile" data-bs-toggle="dropdown"
           aria-expanded="false">
            <img src="{{ asset('images/local/nobody.png') }}"/>
        </a>

        <ul class="dropdown-menu custom" aria-labelledby="dropdownprofile">
            <li><a class="dropdown-item disabled" href="#">pradanamahendra@gmail.com</a></li>
            <hr>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
        </ul>

    </div>

</div>

<div class="d-flex">

    {{-- <div class="sidebar"> --}}
    <nav id="sidebar" class="sidebar card py-2">
        <ul class="nav flex-column" id="nav_accordion">

            <li class="nav-item">
                <a class="title-role" href="#"> Admin </a>
            </li>

            {{-- <li class="nav-item">
                <a class="title-role" href="#"> Admin </a>
            </li>
            <li class="nav-item has-submenu">
                <a class="nav-link menu" href="#">
                    <i class="material-icons menu-icon">perm_identity</i>
                    <p class="menu-text">Admin</p>
                </a>
                <ul class="submenu  collapse">
                    <li><a class="nav-link menu" href="#"><i class="material-icons menu-icon">perm_identity</i>
                            <p class="menu-text">Submenu item 4</p>
                        </a></li>
                    <li><a class="nav-link menu" href="#">
                            <i class="material-icons menu-icon">perm_identity</i>
                            <p class="menu-text">Submenu item 4</p>
                        </a></li>
                    <li><a class="nav-link menu" href="#">
                            <i class="material-icons menu-icon">perm_identity</i>
                            <p class="menu-text">Submenu item 4</p>
                        </a> </li>
                </ul>
            </li> --}}


            <li class="nav-item">
                <a class="nav-link menu @if ($sidebar == 'beranda') active @endif " href="/admin">
                    <i class="material-icons menu-icon">home</i>
                    <p class="menu-text">Beranda</p>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link menu @if ($sidebar == 'user') active @endif" href="/admin/user">
                    <i class="material-icons menu-icon">person</i>
                    <p class="menu-text">User</p>
                </a>
            </li>

            {{-- <li class="nav-item">
                <a class="nav-link menu @if ($sidebar == 'history') active @endif" href="/admin/history">
                    <i class="material-icons menu-icon">person</i>
                    <p class="menu-text">History</p>
                </a>
            </li> --}}

{{-- 
            <li class="nav-item has-submenu">
                <a class="nav-link menu @if ($sidebar == 'master') active @endif" href="#">
                    <i class="material-icons menu-icon">content_paste</i>
                    <p class="menu-text">Master</p>
                </a>
                <ul class="submenu  collapse ">
                    <li><a class="nav-link menu @if ($sidebar == 'masterbarang') active @endif" href="/admin/masterbarang">
                            <i class="material-icons menu-icon">inventory</i>
                            <p class="menu-text">Barang</p>
                        </a></li>
                    <li><a class="nav-link menu @if ($sidebar == 'masterpelanggan') active @endif" href="/admin/masterpelanggan">
                            <i class="material-icons menu-icon">account_box</i>
                            <p class="menu-text">Pelanggan</p>
                        </a></li>

                </ul>
            </li> --}}

            <li class="nav-item has-submenu">
                <a class="nav-link menu" href="#">
                    <i class="material-icons menu-icon">sync</i>
                    <p class="menu-text">Transaksi</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link menu @if ($sidebar == 'tipe') active @endif" href="/admin/type">
                    <i class="material-icons menu-icon">open_in_new</i>
                    <p class="menu-text">Tipe Iklan</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link menu @if ($sidebar == 'titik') active @endif" href="/admin/titik">
                    <i class="material-icons menu-icon">width_full</i>
                    <p class="menu-text">Titik Iklan</p>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link menu" href="/logout">
                    <i class="material-icons menu-icon">person</i>
                    <p class="menu-text">Logout</p>
                </a>
            </li> --}}
        </ul>
    </nav>


    <div class="w-100 p-4">
        @yield('content')
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="{{ asset('js/base.js') }}"></script>
<script src="{{ asset('css/dropify/js/dropify.js') }}"></script>

<script src="{{ asset('js/dialog.js') }}"></script>
<script type="text/javascript" src="{{ asset('datatable/datatables.min.js') }}"></script>
<script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/browser-image-compression@latest/dist/browser-image-compression.js"></script>
<script src="{{ asset('js/handler_image.js') }}"></script>

<script>
    jQuery.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings) {
        return {
            "iStart": oSettings._iDisplayStart,
            "iEnd": oSettings.fnDisplayEnd(),
            "iLength": oSettings._iDisplayLength,
            "iTotal": oSettings.fnRecordsTotal(),
            "iFilteredTotal": oSettings.fnRecordsDisplay(),
            "iPage": oSettings._iDisplayLength === -1 ?
                0 : Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
            "iTotalPages": oSettings._iDisplayLength === -1 ?
                0 : Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
        };
    };
</script>

@yield('morejs')

</body>

</html>
