<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @can('Dashboard')
            <li class="nav-item">
                <a class="nav-link py-2" href="{{ route('admin.dashboard') }}">
                    <i class="mdi mdi-view-dashboard pr-2 icon-large"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
        @endcan
        @can('Barang Index')
            <li class="nav-item">
                <a class="nav-link py-2" href="{{ route('admin.barang.index') }}">
                    <i class="mdi mdi-package pr-2 icon-large"></i>
                    <span class="menu-title">Barang</span>
                </a>
            </li>
        @endcan
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#transaksi" aria-expanded="false"
                aria-controls="transaksi">
                <i class="mdi mdi-cart pr-2 icon-large"></i>
                <span class="menu-title">Transaksi</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="transaksi">
                <ul class="nav flex-column sub-menu">
                    @can('Barang Masuk Index')
                        <li class="nav-item">
                            <a class="nav-link" href=" {{ route('admin.barang-masuk.index') }}"> Barang Masuk</a>
                        </li>
                    @endcan
                    @can('Barang Keluar Index')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.barang-keluar.index') }}"> Barang Keluar</a>
                        </li>
                    @endcan
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#laporan" aria-expanded="false" aria-controls="laporan">
                <i class="mdi mdi-file-document pr-2 icon-large"></i>
                <span class="menu-title">Laporan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="laporan">
                <ul class="nav flex-column sub-menu">
                    @can('Laporan Barang Masuk Index')
                        <li class="nav-item">
                            <a class="nav-link" href=""> Barang Masuk</a>
                        </li>
                    @endcan
                    @can('Laporan Barang Keluar Index')
                        <li class="nav-item">
                            <a class="nav-link" href=""> Barang Keluar</a>
                        </li>
                    @endcan
                </ul>
            </div>
        </li>
        @canany(['Role Index', 'Permission Index', 'User Index'])
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#manajemen_user" aria-expanded="false"
                    aria-controls="manajemen_user">
                    <i class="mdi mdi-account-group pr-2 icon-large"></i>
                    <span class="menu-title">Manajemen User</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="manajemen_user">
                    <ul class="nav flex-column sub-menu">
                        @can('Role Index')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.roles.index') }}"> Role</a>
                            </li>
                        @endcan
                        @can('Permission Index')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.permissions.index') }}">Permission </a>
                            </li>
                        @endcan
                        @can('User Index')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.users.index') }}"> User </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcanany
        @canany(['Jenis Index', 'Satuan Index', 'Supplier Index'])
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#master_data" aria-expanded="false"
                    aria-controls="master_data">
                    <i class="mdi mdi-database pr-2 icon-large"></i>
                    <span class="menu-title">Master Data</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="master_data">
                    <ul class="nav flex-column sub-menu">
                        @can('Jenis Index')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.jenis.index') }}"> Jenis Barang</a>
                            </li>
                        @endcan
                        @can('Satuan Index')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.satuan.index') }}"> Satuan Barang </a>
                            </li>
                        @endcan
                        @can('Supplier Index')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.supplier.index') }}"> Supplier </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcanany
    </ul>
</nav>
