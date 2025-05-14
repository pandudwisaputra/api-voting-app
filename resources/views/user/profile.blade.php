<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
</head>
<body>
    <h2>Halo, {{ $user->name }}</h2>
    <p>Email: {{ $user->email }}</p>
    <p>Role: {{ $user->role }}</p>

    <form method="GET" action="{{ route('logout.web') }}">
    <button type="submit">Logout</button>
    </form>

    @if (auth()->user()->role === 'voter')
    <br>
    <a href="{{ route('candidates.index') }}">
        <button>Lihat Kandidat</button>
    </a>
    @endif
    @if (auth()->user()->role === 'admin')
    <a href="{{ route('admin.candidates.index') }}">
        <br>
        <button>Kelola Kandidat (Admin)</button>
    </a>
    <br>
    <br>
    <a href="{{ route('admin.results.index') }}">
    <button>Lihat Hasil Voting</button>
    </a>
    @endif
</body>
</html>
