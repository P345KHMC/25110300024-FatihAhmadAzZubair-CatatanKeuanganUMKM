@extends('layouts.app')
@section('title', 'Masuk')
@section('content')
<form method='POST' action="{{ route('login') }}">
    @csrf
    <label>Email</label>
    <input type="email" name="email" value="{{ old('email') }}" required>
    @error('email')
        <div class="error">{{ $message }}</div>
    @enderror

    <label>Password</label>
    <input type="password" name="password" required>

    <label><input type="checkbox" name="remember" style="width: auto"> Ingat saya</label>

    <button type="submit">Masuk</button>
</form>
<p>Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
@endsection