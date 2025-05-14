<h2>Tambah Kandidat</h2>
@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="{{ route('admin.candidates.store') }}">
    @csrf
    <label>Nama:</label><br>
    <input type="text" name="name" required><br><br>
    <label>Deskripsi:</label><br>
    <textarea name="description" required></textarea><br><br>
    <button type="submit">Simpan</button>
</form>
<a href="{{ route('admin.candidates.index') }}">Kembali</a>
