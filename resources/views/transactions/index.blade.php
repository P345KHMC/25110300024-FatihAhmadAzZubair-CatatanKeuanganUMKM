@extends('layouts.app')
@section('title', 'Transaksi')
@section('content')
<h2>Transaksi</h2>
<a href="{{ route('transactions.create') }}">+ Catat Transaksi</a>

<table>
    <tr><th>Tanggal</th><th>Kategori</th><th>Produk</th><th>Jumlah</th><th>Keterangan</th><th>Aksi</th></tr>
    @forelse ($transactions as $t)
        <tr>
            <td>{{ $t->transaction_date->format('d M Y') }}</td>
            <td>{{ $t->category->name }}</td>
            <td>{{ $t->product->name ?? '-' }}</td>
            <td>
                {{ $t->category->type === 'income' ? '+' : '-'}}
                Rp {{ number_format($t->amount, 0, ',', '.') }}
            </td>
            <td>{{ $t->description }}</td>
            <td>
                <a href="{{ route('transactions.edit', $t) }}">Edit</a>
                <form class="inline" method="POST" action="{{ route('transactions.destroy', $t) }}"
                        onsubmit="return confirm('Hapus transaksi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="6">Belum ada transaksi</td></tr>
    @endforelse
</table>
@endsection