@extends('layouts.admin')

@section('content')
<div class="admin-dashboard">
    <div class="dashboard-header">
        <div>
            <h1>Create New Feature</h1>
            <p>Add a new property feature to the system</p>
        </div>
        <a href="{{ route('admin.features.index') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Back to Features
        </a>
    </div>
    
    <div class="form-container">
        <form action="{{ route('admin.features.store') }}" method="POST" class="admin-form">
            @csrf
            
            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="name">Feature Name <span class="required">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    <div class="help-text">Enter a descriptive name for this feature (e.g. "Swimming Pool", "Garden", "Garage")</div>
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="submit-btn">
                    <i class="fa-solid fa-save"></i> Create Feature
                </button>
                <a href="{{ route('admin.features.index') }}" class="cancel-btn">
                    <i class="fa-solid fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
