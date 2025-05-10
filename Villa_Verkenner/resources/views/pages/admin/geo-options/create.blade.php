@extends('layouts.admin')

@section('content')
<div class="admin-dashboard">
    <div class="dashboard-header">
        <div>
            <h1>Nieuwe Locatie Optie Aanmaken</h1>
            <p>Voeg een nieuwe locatie optie toe aan het systeem</p>
        </div>
        <a href="{{ route('admin.geo-options.index') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Terug naar Locatie Opties
        </a>
    </div>
    
    <div class="form-container">
        <form action="{{ route('admin.geo-options.store') }}" method="POST" class="admin-form">
            @csrf
            
            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="name">Naam Locatie Optie <span class="required">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    {{-- <div class="help-text">Voer een beschrijvende naam in voor deze locatie optie (bijv. "Nabij Strand", "Stadscentrum", "Bergzicht")</div> --}}
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="submit-btn">
                    <i class="fa-solid fa-save"></i> Locatie Optie Aanmaken
                </button>
                <a href="{{ route('admin.geo-options.index') }}" class="cancel-btn">
                    <i class="fa-solid fa-times"></i> Annuleren
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
