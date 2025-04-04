@extends('layouts.admin')

@section('content')
<div class="admin-dashboard">
    <div class="dashboard-header">
        <div>
            <h1>Edit Feature</h1>
            <p>Update an existing property feature</p>
        </div>
        <a href="{{ route('admin.features.index') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Back to Features
        </a>
    </div>
    
    <div class="form-container">
        <form action="{{ route('admin.features.update', $feature->id) }}" method="POST" class="admin-form">
            @csrf
            @method('PUT')
            
            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="name">Feature Name <span class="required">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $feature->name) }}" required>
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="submit-btn">
                    <i class="fa-solid fa-save"></i> Update Feature
                </button>
                <a href="{{ route('admin.features.index') }}" class="cancel-btn">
                    <i class="fa-solid fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
