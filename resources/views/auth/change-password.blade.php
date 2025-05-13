@extends('layouts.template')

@section('content')
<div class="container">
    <h3>Ganti Password</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <div class="form-group">
            <label>Password Lama</label>
            <input type="password" name="old_password" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Password Baru</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Update Password</button>
    </form>
</div>
@endsection
