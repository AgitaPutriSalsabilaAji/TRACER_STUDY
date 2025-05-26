<aside class="main-sidebar sidebar-light-primary elevation-4">
<a href="{{ url('/dashboard') }}" class="brand-link d-flex align-items-center" style="padding: 10px 15px;">
    <img src="{{ asset('image/logo_polinema.png') }}" alt="Logo Polinema"
         style="height: 40px; width: auto; margin-right: 8px;">
    <span class="brand-text font-weight-bold" style="font-size: 22px; color: #2a70d4;">Tracer Study</span>
</a>

    <hr class="sidebar-divider" style="border-color: rgb(0, 0, 0); margin: 0;">

    <div class="sidebar">
        <div class="mt-3 pb-3 mb-1 d-flex justify-content-center" id="userPanel">
            <div class="info">
                <a style="color: white;" id="userName">
                    {{ Auth::user()->username }}
                </a>
                <i class="fas fa-user-shield" style="color: white; font-size: 24px;" id="userIcon"></i>
            </div>
        </div>

        <hr class="sidebar-divider" style="border-color: white; margin: 0;">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Manajemen Data -->
                <li class="nav-item has-treeview {{ Request::is('import-lulusan') || Request::is('profesi') || Request::is('list-admin') ? 'menu-open' : '' }}">
                    <a  class="nav-link {{ Request::is('import-lulusan') || Request::is('profesi') || Request::is('list-admin') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Manajemen Data
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/import-lulusan') }}" class="nav-link {{ Request::is('import-lulusan') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Import Data Lulusan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/profesi') }}" class="nav-link {{ Request::is('profesi') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengelolaan Profesi</p>
                            </a>                            
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/list-admin') }}" class="nav-link {{ Request::is('list-admin') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List Admin</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('data-alumni') }}" class="nav-link {{ Request::is('data-alumni') ? 'active' : '' }}">
                              <i class="far fa-circle nav-icon"></i>
                              <p>Data Alumni</p>
                            </a>
                          </li>
                          
                    </ul>
                </li>

                <!-- Laporan -->
                <li class="nav-item">
                    <a href="{{ url('/laporan') }}" class="nav-link {{ Request::is('laporan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>Laporan</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
