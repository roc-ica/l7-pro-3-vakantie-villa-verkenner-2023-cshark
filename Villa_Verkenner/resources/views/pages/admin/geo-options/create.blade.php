@extends('layouts.admin')

@section('content')
<div class="admin-dashboard">
    <div class="dashboard-header">
        <div>
            <h1>Create New Location Option</h1>
            <p>Add a new property location option to the system</p>
        </div>
        <a href="{{ route('admin.geo-options.index') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Back to Location Options
        </a>
    </div>
    
    <div class="form-container">
        <form action="{{ route('admin.geo-options.store') }}" method="POST" class="admin-form">
            @csrf
            
            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="name">Location Option Name <span class="required">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    <div class="help-text">Enter a descriptive name for this location option (e.g. "Near Beach", "City Center", "Mountain View")</div>
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="submit-btn">
                    <i class="fa-solid fa-save"></i> Create Location Option
                </button>
                <a href="{{ route('admin.geo-options.index') }}" class="cancel-btn">
                    <i class="fa-solid fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
