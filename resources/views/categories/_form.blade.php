<label>Nama</label>
<input type="text", name="name" value="{{ old('name', $category->name ?? '')}}" required>
@error('name')
    <div class="error">{{ $message }}</div>
@enderror

<label>Tipe</label>
<select name="type" required>
    <option value="income" @selected(old('type', $category->type ?? '') === 'income')>Pemasukan</option>
    <option value="expense" @selected(old('type', $category->type ?? '') === 'expense')>Pengeluaran</option>
</select>
@error('type')
    <div class="error"> {{ $message }}</div>
@enderror

<button type="submit">Simpan</button>
<a href="{{ route('categories.index') }}">Batal</a>