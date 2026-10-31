@extends('layouts.app')
@section('title', 'Edit Produk')
@section('content')
<h2>Edit Produk</h2>
<form method="POST" action="{{ route('products.update', $product) }}">
    @csrf
    @method('PUT')
    @include('products._form')
</form>
@endsection