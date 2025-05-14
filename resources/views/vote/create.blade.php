<!DOCTYPE html>
<html>
<head>
    <title>Vote</title>
</head>
<body>
    <h2>Pilih Kandidat</h2>

    @if (session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('vote.store') }}">
        @csrf
        @foreach($candidates as $candidate)
            <input type="radio" name="candidate_id" value="{{ $candidate->id }}" required>
            {{ $candidate->name }} - {{ $candidate->description }}<br>
        @endforeach

        <br>
        <button type="submit">Kirim Vote</button>
    </form>

    <br>
    <a href="{{ route('profile') }}">
        <button>Kembali ke Profil</button>
    </a>
</body>
</html>
