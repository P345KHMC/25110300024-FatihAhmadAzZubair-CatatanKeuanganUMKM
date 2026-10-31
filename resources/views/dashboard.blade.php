@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<h2>Dashboard</h2>
<p>Halo, {{ auth()->user()->name }}!
    @if ($isAdmin)
        <strong>(Admin: menampilkan data semua pengguna)</strong>
    @endif
</p>

<h3>Ringkasan Keseluruhan</h3>
<table>
    <tr><th>Total Pemasukan</th><td>Rp {{ number_format($income, 0, ',', '.') }}</td></tr>
    <tr><th>Total Pengeluaran</th><td>Rp {{ number_format($expense, 0, ',', '.') }}</td></tr>
    <tr><th>Saldo</th><td><strong>Rp {{ number_format($balance, 0, ',', '.') }}</strong></td></tr>
</table>

<h3>Bulan Ini ({{ now()->format('F Y') }})</h3>
<table>
    <tr><th>Pemasukan</th><td>Rp {{ number_format($monthIncome, 0, ',', '.') }}</td></tr>
    <tr><th>Pengeluaran</th><td>Rp {{ number_format($monthExpense, 0, ',', '.') }}</td></tr>
    <tr><th>Selisih</th><td><strong>Rp {{ number_format($monthIncome - $monthExpense, 0, ',', '.') }}</strong></td></tr>
</table>

<h3>Per Kategori</h3>
<table>
    <tr><th>Kategori</th><th>Tipe</th><th>Total</th></tr>
    @forelse ($perCategory as $row)
        <tr>
            <td>{{ $row->name }}</td>
            <td>{{ $row->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}</td>
            <td>Rp {{ number_format($row->total, 0, ',', '.') }}</td>
        </tr>
    @empty
        <tr><td colspan="3">Belum ada data</td></tr>
    @endforelse
</table>

<h3>5 Transaksi Terakhir</h3>
<table>
    <tr><th>Tanggal</th><th>Kategori</th><th>Jumlah</th><th>Keterangan</th></tr>
    @forelse ($recent as $t)
        <tr>
            <td>{{ $t->transaction_date->format('d M Y') }}</td>
            <td>{{ $t->category->name }}</td>
            <td>
                {{ $t->category->type === 'income' ? '+' : '-' }}
                Rp {{ number_format($t->amount, 0, ',', '.') }}
            </td>
            <td>{{ $t->description }}</td>
        </tr>
    @empty
        <tr><td colspan="4">Belum ada transaksi</td></tr>
    @endforelse
</table>
@endsection