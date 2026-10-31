@extends('layouts.app')
@section('title', 'Kategori')
@section('content')
<h2>Kategori</h2>
<a href="{{ route('categories.create') }}">+ Tambah Kategori</a>

<table>
    <tr><th>Nama</th><th>Tipe</th><th>Aksi</th></tr>
    @forelse ($categories as $category)
        <tr>
            <td>{{ $category->name }}</td>
            <td>{{ $category->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}</td>
            <td>
                <a href="{{ route('categories.edit', $category) }}">Edit</a>
                <form class="inline" method="POST" action="{{ route('categories.destroy', $category) }}"
                        onsubmit="return confirm('Hapus kategori ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="3">Belum ada kategori</td></tr>
    @endforelse
</table>
@endsection