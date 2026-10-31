@extends('layouts.app')
@section('title', 'Produki')
@section('content')
<h2>Produk</h2>
<a href="{{ route('products.create') }}">+ Tambah Produk</a>

<table>
    <tr><th>Nama</th><th>Harga</th><th>Stock</th><th>Aksi</th></tr>
    @forelse ($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
            <td>{{ $product->stock }}</td>
            <td>
                <a href="{{ route('products.edit', $product) }}">Edit</a>
                <form class="inline" method="POST" action="{{ route('products.destroy', $product) }}"
                        onsubmit="return confirm('Hapus produk ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="3">Belum ada produk</td></tr>
    @endforelse
</table>
@endsection