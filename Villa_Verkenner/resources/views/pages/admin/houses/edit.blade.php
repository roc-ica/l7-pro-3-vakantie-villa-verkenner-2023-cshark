@extends('layouts.admin')

@section('content')
    <div class="admin-dashboard">
        <div class="dashboard-header">
            <div>
                <h1>Edit House</h1>
                <p>Update property information</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i> Back to Houses
            </a>
        </div>

        <div class="form-container">
            <form action="{{ route('admin.houses.update', $house) }}" method="POST" enctype="multipart/form-data"
                class="admin-form">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Property Name <span class="required">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $house->name) }}"
                            required>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Price (€) <span class="required">*</span></label>
                        <input type="number" id="price" name="price" value="{{ old('price', $house->price) }}"
                            required min="25000" max="2000000" step="0.01">
                        @error('price')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="rooms">Number of Rooms <span class="required">*</span></label>
                        <input type="number" id="rooms" name="rooms" value="{{ old('rooms', $house->rooms) }}"
                            required min="1" max="20" step="1">
                        @error('rooms')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Property Status <span class="required">*</span></label>
                        <select id="status" name="status" required>
                            <option value="Beschikbaar"
                                {{ old('status', $house->status) == 'Beschikbaar' ? 'selected' : '' }}>Available</option>
                            <option value="Verkocht" {{ old('status', $house->status) == 'Verkocht' ? 'selected' : '' }}>
                                Sold</option>
                        </select>
                        @error('status')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="popular">Featured Property <span class="required">*</span></label>
                        <select id="popular" name="popular" required>
                            <option value="0"
                                {{ old('popular', $house->popular) == '0' || old('popular', $house->popular) === 0 ? 'selected' : '' }}>
                                Not Featured</option>
                            <option value="1"
                                {{ old('popular', $house->popular) == '1' || old('popular', $house->popular) === 1 ? 'selected' : '' }}>
                                Featured</option>
                        </select>
                        @error('popular')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="address">Address <span class="required">*</span></label>
                        <input type="text" id="address" name="address" value="{{ old('address', $house->address) }}"
                            required>
                        @error('address')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="description">Description <span class="required">*</span></label>
                        <textarea id="description" name="description" rows="5" required>{{ old('description', $house->description) }}</textarea>
                        @error('description')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="image">Property Image</label>

                        @if ($house->image)
                            <div class="current-image">
                                <img src="{{ asset('storage/' . $house->image) }}" alt="{{ $house->name }}"
                                    width="200">
                                <p>Current Image</p>
                            </div>
                        @endif

                        <div class="file-input-container">
                            <input type="file" id="image" name="image" accept="image/*">
                            <label for="image" class="file-input-label">
                                <i class="fa-solid fa-cloud-upload-alt"></i> Change Image
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
                        <h3>Features <span class="required">*</span></h3>
                        <div class="checkbox-grid">
                            @foreach ($features as $feature)
                                <div class="checkbox-item">
                                    <input type="checkbox" id="feature_{{ $feature->id }}" name="features[]"
                                        value="{{ $feature->id }}"
                                        {{ in_array($feature->id, old('features', $selectedFeatures)) ? 'checked' : '' }}
                                        class="feature-checkbox">
                                    <label for="feature_{{ $feature->id }}">{{ $feature->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        @error('features')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-section">
                        <h3>Location Options <span class="required">*</span></h3>
                        <div class="checkbox-grid">
                            @foreach ($geoOptions as $option)
                                <div class="checkbox-item">
                                    <input type="checkbox" id="geo_option_{{ $option->id }}" name="geo_options[]"
                                        value="{{ $option->id }}"
                                        {{ in_array($option->id, old('geo_options', $selectedGeoOptions)) ? 'checked' : '' }}
                                        class="geo-option-checkbox">
                                    <label for="geo_option_{{ $option->id }}">{{ $option->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        @error('geo_options')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-btn">
                        <i class="fa-solid fa-save"></i> Update House
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="cancel-btn">
                        <i class="fa-solid fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'No file chosen';
            document.querySelector('.file-name').textContent = fileName;
        });
        document.getElementById('image').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'No file chosen';
            document.querySelector('.file-name').textContent = fileName;
        });

        document.querySelector('form.admin-form').addEventListener('submit', function(e) {
            const features = document.querySelectorAll('.feature-checkbox:checked');
            if (features.length === 0) {
                e.preventDefault();
                alert('Please select at least one feature for this property');
                document.querySelector('.form-section:nth-child(1)').scrollIntoView({
                    behavior: 'smooth'
                });
                return false;
            }
            const geoOptions = document.querySelectorAll('.geo-option-checkbox:checked');
            if (geoOptions.length === 0) {
                e.preventDefault();
                alert('Please select at least one location option for this property');
                document.querySelector('.form-section:nth-child(2)').scrollIntoView({
                    behavior: 'smooth'
                });
                return false;
            }
        });
    </script>
@endsection
