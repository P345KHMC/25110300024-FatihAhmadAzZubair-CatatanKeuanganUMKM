@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<h2>Dashboard</h2>
<p>Halo, {{ auth()->user()->name }}!</p>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Keluar</button>
</form>
@endsection