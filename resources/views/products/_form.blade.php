<label>Nama Produk</label>
<input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required>
@error('name')
    <div class="error">{{ $message }}</div>    
@enderror

<label>Harga (Rp)</label>
<input type="number" name="price" step="0.01" min="0" value="{{ old('price', $product->price ?? '') }}" required>
@error('price')
    <div class="error">{{ $message }}</div>    
@enderror

<label>Stok</label>
<input type="number" name="stock" min="0" value="{{ old('stock', $product->stock ?? '') }}" required>
@error('stock')
    <div class="error">{{ $message }}</div>    
@enderror

<button type="submit">Simpan</button>
<a href="{{ route('products.index') }}">Batal</a>