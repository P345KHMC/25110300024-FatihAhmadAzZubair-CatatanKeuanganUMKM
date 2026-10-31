<label>Kategori</label>
<select name="category_id" required>
    <option value="">-- Pilih kategori --</option>
    @foreach ($categories as $category)
        <option value="{{ $category->id }}"
            @selected(old('category_id', $transaction->category_id ?? '') == $category->id)>
            {{ $category->name }} ({{ $category->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }})
        </option>
    @endforeach
</select>
@error('category_id')
    <div class="error">{{ $message }}</div>
@enderror
@if ($categories->isEmpty())
    <div class="error">Belum ada kategori. <a href="{{ route('categories.create') }}">Buat dulu</a></div>
@endif 

<label>Produk (opsional)</label>
<select name="product_id">
    <option value="">-- Tanpa produk --</option>
    @foreach ($products as $product)
        <option value="{{ $product->id }}"
            @selected(old('product_id', $transaction->product_id ?? '') == $product->id)>
            {{ $product->name }}
        </option>
    @endforeach
</select>
@error('product_id')
    <div class="error">{{ $message }}</div>
@enderror

<label>Jumlah (Rp)</label>
<input type="number" name="amount" step="0.01" min="0.01"
    value="{{ old('amount', $transaction->amount ?? '') }}" required>
@error('amount')
    <div class="error">{{ $message }}</div>
@enderror

<label>Tanggal</label>
<input type="date" name="transaction_date"
    value="{{ old('transaction_date', isset($transaction) ? $transaction->transaction_date->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
@error('transaction_date')
    <div class="error">{{ $message }}</div>
@enderror

<label>Keterangan</label>
<input type="text" name="description" maxlength="255""
    value="{{ old('description', $transaction->description ?? '') }}">
@error('description')
    <div class="error">{{ $message }}</div>
@enderror

<button type="submit">Simpan</button>
<a href="{{ route('transactions.index') }}">Batal</a>