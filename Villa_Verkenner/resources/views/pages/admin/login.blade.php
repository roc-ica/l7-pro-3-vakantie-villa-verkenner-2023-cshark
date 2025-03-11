<!-- resources/views/pages/admin/login.blade.php -->

@extends('layouts.admin')

@section('content')
    <form method="POST" action="{{ route('admin.login') }}">
        @csrf
        <div>
            <label for="username">Gebruikersnaam</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Wachtwoord</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
    </form>

    @if($errors->any())
        <div>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
