@extends('layouts.admin')

@section('content')
    <div class="admin-dashboard">
        <div class="dashboard-header">
            <div>
                <h1>Woning Bewerken</h1>
                <p>Woninginformatie bijwerken</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i> Terug naar Woningen
            </a>
        </div>

        <div class="form-container">
            <form action="{{ route('admin.houses.update', $house) }}" method="POST" enctype="multipart/form-data"
                class="admin-form">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Naam Woning <span class="required">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $house->name) }}"
                            required>
                        @error('name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Prijs (€) <span class="required">*</span></label>
                        <input type="number" id="price" name="price" value="{{ old('price', $house->price) }}"
                            required min="25000" max="2000000" step="0.01">
                        @error('price')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="rooms">Aantal Kamers <span class="required">*</span></label>
                        <input type="number" id="rooms" name="rooms" value="{{ old('rooms', $house->rooms) }}"
                            required min="1" max="20" step="1">
                        @error('rooms')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status Woning <span class="required">*</span></label>
                        <select id="status" name="status" required>
                            <option value="Beschikbaar"
                                {{ old('status', $house->status) == 'Beschikbaar' ? 'selected' : '' }}>Beschikbaar</option>
                            <option value="Verkocht" {{ old('status', $house->status) == 'Verkocht' ? 'selected' : '' }}>
                                Verkocht</option>
                        </select>
                        @error('status')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="popular">Populaire Woning <span class="required">*</span></label>
                        <select id="popular" name="popular" required>
                            <option value="0"
                                {{ old('popular', $house->popular) == '0' || old('popular', $house->popular) === 0 ? 'selected' : '' }}>
                                Niet Populair</option>
                            <option value="1"
                                {{ old('popular', $house->popular) == '1' || old('popular', $house->popular) === 1 ? 'selected' : '' }}>
                                Populair</option>
                        </select>
                        @error('popular')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="address">Adres <span class="required">*</span></label>
                        <input type="text" id="address" name="address" value="{{ old('address', $house->address) }}"
                            required>
                        @error('address')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="description">Beschrijving <span class="required">*</span></label>
                        <textarea id="description" name="description" rows="5" required maxlength="5000">{{ old('description', $house->description) }}</textarea>
                        @error('description')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label>Huidige Afbeeldingen</label>
                        <div class="current-images-container">
                            @if ($house->images->count() > 0)
                                <div class="images-grid" id="sortable-images">
                                    @foreach ($house->images as $image)
                                        <div class="image-item" data-id="{{ $image->id }}">
                                            <div class="image-wrapper">
                                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $house->name }}">
                                                @if ($image->is_primary)
                                                    <div class="primary-badge">Primair</div>
                                                @endif
                                            </div>
                                            <div class="image-actions">
                                                <label class="make-primary-label">
                                                    <input type="radio" name="primary_image_id" value="{{ $image->id }}" 
                                                        {{ $image->is_primary ? 'checked' : '' }}>
                                                    Maak primair
                                                </label>
                                                <label class="delete-image-label">
                                                    <input type="checkbox" name="delete_image_ids[]" value="{{ $image->id }}">
                                                    Verwijderen
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @else
                                <p>Geen afbeeldingen beschikbaar.</p>
                            @endif
                        </div>
                        @error('delete_image_ids')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        @error('primary_image_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="new_images">Nieuwe Afbeeldingen Toevoegen</label>
                        <div class="file-input-container">
                            <input type="file" id="new_images" name="new_images[]" accept="image/*" multiple>
                            <label for="new_images" class="file-input-label">
                                <i class="fa-solid fa-cloud-upload-alt"></i> Afbeeldingen Toevoegen
                            </label>
                            <span class="files-selected">Geen bestanden gekozen</span>
                        </div>
                        <p class="help-text">U kunt extra afbeeldingen toevoegen. Maximaal 5 afbeeldingen in totaal.</p>
                        <div id="image-preview-container" class="image-previews"></div>
                        @error('new_images')
                            <span class="error">{{ $message }}</span>
                        @enderror
                        @error('new_images.*')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-sections">
                    <div class="form-section">
                        <h3>Eigenschappen <span class="required">*</span></h3>
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
                        <h3>Locatie Opties <span class="required">*</span></h3>
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
                        <i class="fa-solid fa-save"></i> Woning Bijwerken
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="cancel-btn">
                        <i class="fa-solid fa-times"></i> Annuleren
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Handle file input for new images
        document.getElementById('new_images').addEventListener('change', function(e) {
            const files = e.target.files;
            const fileCount = files.length;
            const currentImagesCount = {{ $house->images->count() }};
            const totalImagesAfterUpload = currentImagesCount + fileCount;
            
            if (fileCount === 0) {
                document.querySelector('.files-selected').textContent = 'Geen bestanden gekozen';
            } else if (totalImagesAfterUpload > 5) {
                document.querySelector('.files-selected').textContent = `Te veel afbeeldingen. Maximum is 5. U heeft er al ${currentImagesCount}.`;
                this.value = '';
                return;
            } else {
                document.querySelector('.files-selected').textContent = `${fileCount} ${fileCount === 1 ? 'bestand' : 'bestanden'} gekozen`;
            }
            
            // Preview images
            const previewContainer = document.getElementById('image-preview-container');
            previewContainer.innerHTML = '';
            
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();
                
                reader.onload = function(event) {
                    const previewDiv = document.createElement('div');
                    previewDiv.className = 'image-preview';
                    previewDiv.innerHTML = `<img src="${event.target.result}" alt="Preview">`;
                    previewContainer.appendChild(previewDiv);
                };
                
                reader.readAsDataURL(file);
            }
        });

        // Make sure at least one image remains
        document.querySelector('form.admin-form').addEventListener('submit', function(e) {
            const deleteCheckboxes = document.querySelectorAll('input[name="delete_image_ids[]"]:checked');
            const currentImagesCount = {{ $house->images->count() }};
            const newImagesCount = document.getElementById('new_images').files.length;
            
            if (deleteCheckboxes.length >= currentImagesCount && newImagesCount === 0) {
                e.preventDefault();
                alert('U moet ten minste één afbeelding voor de woning behouden.');
                return false;
            }
            
            const features = document.querySelectorAll('.feature-checkbox:checked');
            if (features.length === 0) {
                e.preventDefault();
                alert('Selecteer a.u.b. ten minste één eigenschap voor deze woning');
                document.querySelector('.form-section:nth-child(1)').scrollIntoView({
                    behavior: 'smooth'
                });
                return false;
            }
            
            const geoOptions = document.querySelectorAll('.geo-option-checkbox:checked');
            if (geoOptions.length === 0) {
                e.preventDefault();
                alert('Selecteer a.u.b. ten minste één locatie optie voor deze woning');
                document.querySelector('.form-section:nth-child(2)').scrollIntoView({
                    behavior: 'smooth'
                });
                return false;
            }
        });

        // Handle primary image selection
        const primaryRadios = document.querySelectorAll('input[name="primary_image_id"]');
        primaryRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                // Remove primary badge from all images
                document.querySelectorAll('.primary-badge').forEach(badge => {
                    badge.remove();
                });
                
                // Add primary badge to selected image
                if (this.checked) {
                    const imageItem = this.closest('.image-item');
                    const imageWrapper = imageItem.querySelector('.image-wrapper');
                    const badge = document.createElement('div');
                    badge.className = 'primary-badge';
                    badge.textContent = 'Primair';
                    imageWrapper.appendChild(badge);
                }
            });
        });

        // Make images sortable
        if (typeof jQuery !== 'undefined' && jQuery.ui) {
            $(function() {
                $("#sortable-images").sortable({
                    update: function(event, ui) {
                        const order = [];
                        $('.image-item').each(function(index) {
                            order.push($(this).data('id'));
                        });
                        
                        // Send AJAX request to update order
                        $.ajax({
                            url: '{{ route("admin.houses.reorder-images", $house) }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                image_order: order
                            },
                            success: function(response) {
                                console.log('Image order updated successfully');
                            },
                            error: function(xhr) {
                                console.error('Error updating image order');
                            }
                        });
                    }
                });
                $("#sortable-images").disableSelection();
            });
        }
    </script>
@endsection
