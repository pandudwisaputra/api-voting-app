<!DOCTYPE html>
<html>
<head>
    <title>Daftar Kandidat</title>
</head>
<body>
    <h2>Daftar Kandidat</h2>

    <ul>
        @foreach($candidates as $candidate)
            <li>
                <strong>{{ $candidate->name }}</strong><br>
                {{ $candidate->description }}
            </li>
            <br>
        @endforeach
    </ul>
    <a href="{{ route('vote.create') }}">
        <button>Vote Kandidat</button>
    </a>
    <br>
    <br>
    <a href="{{ route('profile') }}">
        <button>Kembali ke Profil</button>
    </a>
</body>
</html>
