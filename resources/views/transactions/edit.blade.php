@extends('layouts.app')
@section('title', 'Edit Transaksi')
@section('content')
<h2>Edit Transaksi</h2>
<form method="POST" action="{{ route('transactions.update', $transaction) }}">
    @csrf
    @method('PUT')
    @include('transactions._form')
</form>
@endsection