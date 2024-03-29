<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="slimscroll-menu">

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <div class="user-box">
    
                <div class="float-left">
                    <img src="/assets/images/users/avatar-1.jpg" alt="" class="avatar-md rounded-circle">
                </div>
                <div class="user-info">
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ auth()->user()->name }} <i class="mdi mdi-chevron-down"></i></a>
                        <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 29px, 0px); top: 0px; left: 0px; will-change: transform;">
                            <li><a href="javascript:void(0)" class="dropdown-item"><i class="mdi mdi-face-profile mr-2"></i> Profile<div class="ripple-wrapper"></div></a></li>
                            <li><a href="#" class="dropdown-item" data-toggle="modal" data-target=".modalKeluar"><i class="mdi mdi-power-settings mr-2"></i> Logout</a></li>
                        </ul>
                    </div>
                    <p class="font-13 text-muted m-0">{{ auth()->user()->username }}</p>
                </div>
            </div>

            <ul class="metismenu" id="side-menu">

                <li>
                    <a href="{{ url('/') }}" class="waves-effect">
                        <i class="mdi mdi-home"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                
                @can('Owner')
                <li>
                    <a href="{{ route('b.index') }}" class="waves-effect">
                        <i class="mdi mdi mdi-database"></i>
                        <span> Master Barang </span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="mdi mdi mdi-file-document-box-plus"></i>
                        <span> Master Stok Barang </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="{{ route('pb.create') }}">Input pembelian</a></li>
                        <li><a href="{{ route('pb.index') }}">Daftar Pembelian</a></li>
                    </ul>
                </li>
                @endcan

                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="mdi mdi mdi-file-document-box-minus"></i>
                        <span> Master Penjualan </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level mm-collapse" aria-expanded="false">
                        <li><a href="{{ route('pe.index') }}">Data Pembeli</a></li>
                        <li><a href="{{ route('pj.create') }}">Input Penjualan</a></li>
                        <li><a href="{{ route('pj.index') }}">Data Penjualan</a></li>
                    </ul>
                </li>
                @can('Owner')
                <li>
                    <a href="javascript: void(0);" class="waves-effect">
                        <i class="mdi mdi mdi-file-document-box-check"></i>
                        <span> Rekap Laporan </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="{{ url('/lpp') }}">Laporan perPembeli</a></li>
                        <li><a href="{{ url('/lpb') }}">Laporan Bulanan</a></li>
                        <li><a href="{{ url('/lb') }}">Laba bersih</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ url('/an') }}" class="waves-effect">
                        <i class=" mdi mdi mdi-google-analytics"></i>
                        <span> Analisa Penjualan </span>
                    </a>
                </li>                                
                @endcan
                <li>
                    <a href="#" class="waves-effect" data-toggle="modal" data-target=".modalKeluar">
                        <i class="mdi mdi mdi-logout"></i>
                        <span> Keluar </span>
                    </a>
                </li>
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->