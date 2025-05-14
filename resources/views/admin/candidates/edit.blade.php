<h2>Edit Kandidat</h2>
@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="POST" action="{{ route('admin.candidates.update', $candidate) }}">
    @csrf
    @method('PUT')
    <label>Nama:</label><br>
    <input type="text" name="name" value="{{ $candidate->name }}" required><br><br>
    <label>Deskripsi:</label><br>
    <textarea name="description" required>{{ $candidate->description }}</textarea><br><br>
    <button type="submit">Update</button>
</form>
<a href="{{ route('admin.candidates.index') }}">Kembali</a>

