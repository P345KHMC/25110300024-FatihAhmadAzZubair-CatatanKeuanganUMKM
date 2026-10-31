@extends('layouts.app')
@section('title', 'Edit Kategori')
@section('content')
<h2>Edit Kategori</h2>
<form method="POST" action="{{ route('categories.update', $category) }}">
    @csrf
    @method('PUT')
    @include('categories._form')
</form>
@endsection