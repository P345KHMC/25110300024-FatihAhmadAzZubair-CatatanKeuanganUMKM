@extends('layouts.app')
@section('title', 'Catat Transaksi')
@section('content')
<h2>Catat Transaksi</h2>
<form method="POST" action="{{ route('transactions.store') }}">
    @csrf
    @include('transactions._form')
</form>
@endsection