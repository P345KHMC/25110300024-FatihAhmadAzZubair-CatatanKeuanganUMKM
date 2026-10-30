@extends('layouts.app')
@section('title', 'Daftar')
@section('content')
<h2>Daftar</h2>
<form method="POST" action="{{ route('register') }}">
    @csrf
    <label>Nama</label>
    <input type="text" name="name" value="{{ old('name') }}" required>
    @error('name')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Email</label>
    <input type="email" name="email" value="{{ old('email') }}" required>
    @error('email')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Password</label>
    <input type="password" name="password" required>
    @error('password')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Ulangi Password</label>
    <input type="password" name="password_confirmation" required>

    <button type="submit">Daftar</button>
</form>
<p>Sudah punya akun? <a href="{{ route('login') }}">Masuk</p>
@endsection