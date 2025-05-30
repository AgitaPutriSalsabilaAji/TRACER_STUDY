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
                <a style="color: #5a8dee; font-size: 1.2rem;" id="userName">
                    {{ Auth::user()->username }}
                </a>

                <i class="fas fa-user-shield" style="color: #5a8dee; font-size: 24px;" id="userIcon"></i>
            </div>
        </div>

        <hr class="sidebar-divider" style="border-color: #5a8dee; margin: 0;">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Manajemen Data -->
                <li
                    class="nav-item has-treeview {{ Request::is('data-alumni')|| Request::is('profesi') || Request::is('list-admin') ? 'menu-open' : '' }}">
                    <a style="cursor: pointer;"
                        class="nav-link {{ Request::is('data-alumni')|| Request::is('profesi') || Request::is('list-admin') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Manajemen Data
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ">
                        <li class="nav-item">
                            <a href="{{ url('/profesi') }}"
                                class="nav-link {{ Request::is('profesi') ? 'active' : '' }}">
                                <i class="fas fa-briefcase nav-icon"></i>
                                <p>Pengelolaan Profesi</p>
                            </a>
                        </li>
                        @if (auth()->user()->is_superadmin)
                            <li class="nav-item">
                                <a href="{{ url('/list-admin') }}"
                                    class="nav-link {{ Request::is('list-admin') ? 'active' : '' }}">
                                    <i class="fas fa-user-shield nav-icon"></i>
                                    <p>List Admin</p>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <a href="{{ url('/data-alumni') }}"
                                class="nav-link {{ Request::is('data-alumni') ? 'active' : '' }}">
                                <i class="fas fa-user-graduate nav-icon"></i>
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
