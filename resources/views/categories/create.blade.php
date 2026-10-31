@extends('layouts.app')
@section('title', 'Tambah Kategori')
@section('content')
<h2>Tambah Kategori</h2>
<form method="POST" action="{{ route('categories.store') }}">
    @csrf
    @include('categories._form')
</form>
@endsection