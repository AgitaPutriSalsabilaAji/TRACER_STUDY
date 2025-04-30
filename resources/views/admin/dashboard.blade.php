@extends('layouts.app')
<div class="sidebar">
    <!-- Logo -->
    <a href="{{ url('/') }}" class="brand-link text-center">
        <img src="{{ asset('images/logo.png') }}" alt="Tracer Study Logo" class="brand-image" style="opacity: .8">
        <span class="brand-text font-weight-light">Tracer Study</span>
    </a>

    <!-- Tombol Login -->
    <div class="text-center mt-3">
        <a href="{{ url('/login') }}" class="btn btn-primary btn-sm">LOGIN UNTUK ADMIN</a>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-3">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            
            <!-- Homepage -->
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'home') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-home"></i>
                    <p>Homepage</p>
                </a>
            </li>

            <!-- Data Alumni -->
            <li class="nav-item">
                <a href="{{ url('/alumni') }}" class="nav-link {{ ($activeMenu == 'alumni') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-graduate"></i>
                    <p>Data Alumni</p>
                </a>
            </li>

            <!-- Isi Survei -->
            <li class="nav-item">
                <a href="{{ url('/survei') }}" class="nav-link {{ ($activeMenu == 'survei') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-clipboard-check"></i>
                    <p>Isi Survei</p>
                </a>
            </li>
        </ul>
    </nav>
</div>
