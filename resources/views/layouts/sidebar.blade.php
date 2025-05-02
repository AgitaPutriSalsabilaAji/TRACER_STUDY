<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-olive elevation-4">
    <a href="index3.html" class="brand-link">
        <img src="{{  asset ('adminlte/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Anjay</span>
      </a>

    <hr class="sidebar-divider" style="border-color: white; margin: 0;">

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="mt-3 pb-3 mb-1 d-flex justify-content-center" id="userPanel">
            <div class="info">
                <a href="#" style="color: white;" id="userName">Alexander Pierce</a>
                <i class="fas fa-user-shield" style="color: white; font-size: 24px;" id="userIcon"></i>
            </div>
        </div>


        <hr class="sidebar-divider" style="border-color: white; margin: 0;">
    
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Manajemen Data
                            <i class="right fas fa-angle-down"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#import-lulusan" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Import Data Lulusan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#kelola-profesi" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengelolaan Profesi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tambah-admin" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tambah Admin</p>
                            </a>
                        </li>
                    </ul>
                </li>                
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>Laporan</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
