@extends('layouts.admin')

@section('content')
<div class="admin-dashboard">
    <div class="dashboard-header">
        <div>
            <h1>Locatie Optie Bewerken</h1>
            <p>Bestaande locatie optie bijwerken</p>
        </div>
        <a href="{{ route('admin.geo-options.index') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Terug naar Locatie Opties
        </a>
    </div>
    
    <div class="form-container">
        <form action="{{ route('admin.geo-options.update', $geoOption->id) }}" method="POST" class="admin-form">
            @csrf
            @method('PUT')
            
            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="name">Naam Locatie Optie <span class="required">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $geoOption->name) }}" required>
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="submit-btn">
                    <i class="fa-solid fa-save"></i> Locatie Optie Bijwerken
                </button>
                <a href="{{ route('admin.geo-options.index') }}" class="cancel-btn">
                    <i class="fa-solid fa-times"></i> Annuleren
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
