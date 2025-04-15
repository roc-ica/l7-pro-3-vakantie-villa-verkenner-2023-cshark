@extends('layouts.admin')

@section('content')
<div class="admin-dashboard">
    <div class="dashboard-header">
        <div>
            <h1>Nieuwe Eigenschap Aanmaken</h1>
            <p>Voeg een nieuwe woning eigenschap toe aan het systeem</p>
        </div>
        <a href="{{ route('admin.features.index') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Terug naar Eigenschappen
        </a>
    </div>
    
    <div class="form-container">
        <form action="{{ route('admin.features.store') }}" method="POST" class="admin-form">
            @csrf
            
            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="name">Naam Eigenschap <span class="required">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    {{-- <div class="help-text">Voer een beschrijvende naam in voor deze eigenschap (bijv. "Zwembad", "Tuin", "Garage")</div> --}}
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="submit-btn">
                    <i class="fa-solid fa-save"></i> Eigenschap Aanmaken
                </button>
                <a href="{{ route('admin.features.index') }}" class="cancel-btn">
                    <i class="fa-solid fa-times"></i> Annuleren
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
