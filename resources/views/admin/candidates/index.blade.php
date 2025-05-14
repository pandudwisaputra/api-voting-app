<h2>Daftar Kandidat</h2>
<a href="{{ route('admin.candidates.create') }}">Tambah Kandidat</a>
<table border="1">
    <tr>
        <th>Nama</th>
        <th>Deskripsi</th>
        <th>Aksi</th>
    </tr>
    @foreach($candidates as $candidate)
    <tr>
        <td>{{ $candidate->name }}</td>
        <td>{{ $candidate->description }}</td>
        <td>
            <a href="{{ route('admin.candidates.edit', $candidate) }}">Edit</a>
            <form action="{{ route('admin.candidates.destroy', $candidate) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Yakin hapus?')">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
<br>
<a href="{{ route('vote.create') }}">
        <button>Vote Kandidat</button>
    </a>
    <br>
<br>
    <a href="{{ route('profile') }}">
        <button>Kembali ke Profil</button>
    </a>