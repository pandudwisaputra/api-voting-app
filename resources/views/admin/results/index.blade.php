<!DOCTYPE html>
<html>
<head>
    <title>Hasil Voting</title>
</head>
<body>
    <h2>Hasil Voting</h2>
    <table border="1">
        <tr>
            <th>Nama Kandidat</th>
            <th>Jumlah Vote</th>
        </tr>
        @foreach($candidates as $candidate)
        <tr>
            <td>{{ $candidate->name }}</td>
            <td>{{ $candidate->votes_count }}</td>
        </tr>
        @endforeach
    </table>
    <br>
    <a href="{{ route('profile') }}">Kembali ke Profil</a>
</body>
</html>
