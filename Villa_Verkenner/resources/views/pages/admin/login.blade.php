@extends('layouts.admin')

@section('content')
<div class="admin-login-container">
    <div class="login-card">
        <h2>Villa Verkenner Admin</h2>
        
        <form method="POST" action="{{ route('admin.login') }}" class="admin-login-form">
            @csrf
            <div class="form-group">
                <label for="username">
                    <i class="fa-solid fa-user"></i> Gebruikersnaam
                </label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus>
                @error('username')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="password">
                    <i class="fa-solid fa-lock"></i> Wachtwoord
                </label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <button type="submit" class="login-button">
                Inloggen
            </button>

            @if($errors->any())
                <div class="alert alert-danger" style="margin-top: 1rem;">
                    {{ $errors->first() }}
                </div>
            @endif
        </form>
    </div>
</div>
@endsection