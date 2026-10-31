@extends('layouts.app')
@section('title', 'Tambah Produk')
@section('content')
<h2>Tambah Produk</h2>
<form method="POST" action="{{ route('products.store') }}">
    @csrf
    @include('products._form')
</form>
@endsection