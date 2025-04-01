@extends('layouts.admin')

@section('content')
<div class="admin-dashboard">
    <div class="dashboard-header">
        <div>
            <h1>Create New House</h1>
            <p>Add a new property to your listing</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>
    
    <div class="form-container">
        <form action="{{ route('admin.houses.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
            @csrf
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Property Name <span class="required">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="price">Price (€) <span class="required">*</span></label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" required>
                    @error('price')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="rooms">Number of Rooms <span class="required">*</span></label>
                    <input type="text" id="rooms" name="rooms" value="{{ old('rooms') }}" required>
                    @error('rooms')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="status">Status <span class="required">*</span></label>
                    <select id="status" name="status" required>
                        <option value="Beschikbaar" {{ old('status') == 'Beschikbaar' ? 'selected' : '' }}>Available</option>
                        <option value="Verkocht" {{ old('status') == 'Verkocht' ? 'selected' : '' }}>Sold</option>
                        <option value="Gereserveerd" {{ old('status') == 'Gereserveerd' ? 'selected' : '' }}>Reserved</option>
                    </select>
                    @error('status')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group full-width">
                    <label for="address">Address <span class="required">*</span></label>
                    <input type="text" id="address" name="address" value="{{ old('address') }}" required>
                    @error('address')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group full-width">
                    <label for="description">Description <span class="required">*</span></label>
                    <textarea id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                    @error('description')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group full-width">
                    <label for="image">Property Image</label>
                    <div class="file-input-container">
                        <input type="file" id="image" name="image" accept="image/*">
                        <label for="image" class="file-input-label">
                            <i class="fa-solid fa-cloud-upload-alt"></i> Choose Image
                        </label>
                        <span class="file-name">No file chosen</span>
                    </div>
                    @error('image')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-sections">
                <div class="form-section">
                    <h3>Features</h3>
                    <div class="checkbox-grid">
                        @foreach($features as $feature)
                            <div class="checkbox-item">
                                <input type="checkbox" id="feature_{{ $feature->id }}" name="features[]" value="{{ $feature->id }}"
                                    {{ in_array($feature->id, old('features', [])) ? 'checked' : '' }}>
                                <label for="feature_{{ $feature->id }}">{{ $feature->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="form-section">
                    <h3>Location Options</h3>
                    <div class="checkbox-grid">
                        @foreach($geoOptions as $option)
                            <div class="checkbox-item">
                                <input type="checkbox" id="geo_option_{{ $option->id }}" name="geo_options[]" value="{{ $option->id }}"
                                    {{ in_array($option->id, old('geo_options', [])) ? 'checked' : '' }}>
                                <label for="geo_option_{{ $option->id }}">{{ $option->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="submit-btn">
                    <i class="fa-solid fa-save"></i> Create House
                </button>
                <a href="{{ route('admin.houses.index') }}" class="cancel-btn">
                    <i class="fa-solid fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Display selected filename
    document.getElementById('image').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'No file chosen';
        document.querySelector('.file-name').textContent = fileName;
    });
</script>
@endsection