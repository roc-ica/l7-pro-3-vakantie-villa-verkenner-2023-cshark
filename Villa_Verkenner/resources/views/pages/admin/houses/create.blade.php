@extends('layouts.admin')

@section('content')
<div class="admin-dashboard">
    <div class="dashboard-header">
        <div>
            <h1>Nieuwe Woning Toevoegen</h1>
            <p>Voeg een nieuwe woning toe aan uw aanbod</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i> Terug naar Dashboard
        </a>
    </div>
    
    <div class="form-container">
        <form action="{{ route('admin.houses.store') }}" method="POST" enctype="multipart/form-data" class="admin-form" id="houseForm">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Naam Woning <span class="required">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="price">Prijs (€) <span class="required">*</span></label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" required min="25000" max="2000000" step="0.01">
                    @error('price') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="rooms">Aantal Kamers <span class="required">*</span></label>
                    <input type="number" id="rooms" name="rooms" value="{{ old('rooms') }}" required min="1" max="20" step="1">
                    @error('rooms') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status Woning <span class="required">*</span></label>
                    <select id="status" name="status" required>
                        <option value="Beschikbaar" {{ old('status') == 'Beschikbaar' ? 'selected' : '' }}>Beschikbaar</option>
                        <option value="Verkocht" {{ old('status') == 'Verkocht' ? 'selected' : '' }}>Verkocht</option>
                    </select>
                    @error('status') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="popular">Populaire Woning <span class="required">*</span></label>
                    <select id="popular" name="popular" required>
                        <option value="0" {{ old('popular') == '0' ? 'selected' : '' }}>Niet Populair</option>
                        <option value="1" {{ old('popular') == '1' ? 'selected' : '' }}>Populair</option>
                    </select>
                    @error('popular') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group full-width">
                    <label for="address">Adres <span class="required">*</span></label>
                    <input type="text" id="address" name="address" value="{{ old('address') }}" required>
                    @error('address') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group full-width">
                    <label for="description">Beschrijving <span class="required">*</span></label>
                    <textarea id="description" name="description" rows="5" required maxlength="5000">{{ old('description') }}</textarea>
                    @error('description') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group full-width">
                    <label for="images">Afbeeldingen Woning (1-5) <span class="required">*</span></label>
                    <div class="file-input-container">
                    <input type="file" id="images" name="images[]" accept="image/*" multiple>
                        <label for="images" class="file-input-label">
                            <i class="fa-solid fa-cloud-upload-alt"></i> Kies Afbeeldingen (max 5)
                        </label>
                        <span class="files-selected">Geen bestanden gekozen</span>
                    </div>
                    <input type="hidden" name="primary_image_index" id="primary_image_index" value="0">
                    <div id="image-preview-container" class="image-previews"></div>
                    @error('images') <span class="error">{{ $message }}</span> @enderror
                    @error('images.*') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-sections">
                <div class="form-section">
                    <h3>Eigenschappen <span class="required">*</span></h3>
                    <div class="checkbox-grid">
                        @foreach($features as $feature)
                            <div class="checkbox-item">
                                <input type="checkbox" id="feature_{{ $feature->id }}" name="features[]" value="{{ $feature->id }}"
                                    {{ in_array($feature->id, old('features', [])) ? 'checked' : '' }}
                                    class="feature-checkbox">
                                <label for="feature_{{ $feature->id }}">{{ $feature->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('features') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-section">
                    <h3>Locatie Opties <span class="required">*</span></h3>
                    <div class="checkbox-grid">
                        @foreach($geoOptions as $option)
                            <div class="checkbox-item">
                                <input type="checkbox" id="geo_option_{{ $option->id }}" name="geo_options[]" value="{{ $option->id }}"
                                    {{ in_array($option->id, old('geo_options', [])) ? 'checked' : '' }}
                                    class="geo-option-checkbox">
                                <label for="geo_option_{{ $option->id }}">{{ $option->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('geo_options') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-btn">
                    <i class="fa-solid fa-save"></i> Woning Aanmaken
                </button>
                <a href="{{ route('admin.dashboard') }}" class="cancel-btn">
                    <i class="fa-solid fa-times"></i> Annuleren
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    .image-preview {
        position: relative;
        display: inline-block;
        margin: 8px;
        border: 2px solid #ccc;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .image-preview img {
        max-width: 140px;
        height: auto;
        display: block;
    }
    .image-preview.primary-image {
        border: 2px solid #007bff;
    }
    .primary-badge {
    position: absolute;
    top: 4px;
    left: 4px;
    background: #6c63ff; /* of bijvoorbeeld #007bff als je blauw wil */
    color: #fff;
    font-size: 10px;      /* kleiner lettertype */
    padding: 2px 5px;     /* compacter */
    border-radius: 3px;
    font-weight: 600;
    z-index: 2;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

    .image-preview.primary-image .primary-badge {
        display: block;
    }
    .remove-image {
        position: absolute;
        top: 6px;
        right: 6px;
        background: red;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 0.8rem;
        cursor: pointer;
        padding: 2px 6px;
    }
</style>

<script>
    let selectedFiles = [];
    const imageInput = document.getElementById('images');
    const previewContainer = document.getElementById('image-preview-container');
    const filesText = document.querySelector('.files-selected');
    const primaryIndexInput = document.getElementById('primary_image_index');

    imageInput.addEventListener('change', function () {
        const files = Array.from(imageInput.files);

        if (files.length > 5) {
            filesText.textContent = 'Te veel bestanden gekozen (max 5)';
            imageInput.value = '';
            selectedFiles = [];
            previewContainer.innerHTML = '';
            return;
        }

        selectedFiles = files;
        primaryIndexInput.value = 0;
        renderPreviews();
    });

    function renderPreviews() {
        previewContainer.innerHTML = '';

        // Zet selectedFiles opnieuw in het input veld via DataTransfer
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        imageInput.files = dt.files;

        // Update tekst
        filesText.textContent = `${selectedFiles.length} ${selectedFiles.length === 1 ? 'bestand' : 'bestanden'} gekozen`;

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function (event) {
                const previewDiv = document.createElement('div');
                previewDiv.className = 'image-preview';
                if (index === Number(primaryIndexInput.value)) {
                    previewDiv.classList.add('primary-image');
                }

                previewDiv.innerHTML = `
                    <img src="${event.target.result}" alt="Preview">
                    <div class="primary-badge">Primair</div>
                    <button type="button" class="remove-image" data-index="${index}">Verwijder</button>
                `;

                previewDiv.addEventListener('click', function () {
                    document.querySelectorAll('.image-preview').forEach(div => div.classList.remove('primary-image'));
                    previewDiv.classList.add('primary-image');
                    primaryIndexInput.value = index;
                });

                previewContainer.appendChild(previewDiv);
            };
            reader.readAsDataURL(file);
        });

        // Zet verwijderknoppen goed
        setTimeout(() => {
            const removeButtons = previewContainer.querySelectorAll('.remove-image');
            removeButtons.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const index = Number(btn.dataset.index);

                    selectedFiles.splice(index, 1);

                    // Herstel primaire index
                    if (Number(primaryIndexInput.value) === index || selectedFiles.length === 0) {
                        primaryIndexInput.value = 0;
                    } else if (Number(primaryIndexInput.value) > index) {
                        primaryIndexInput.value = Number(primaryIndexInput.value) - 1;
                    }

                    renderPreviews();
                });
            });
        }, 50);
    }

    document.getElementById('houseForm').addEventListener('submit', function (e) {
        const features = document.querySelectorAll('.feature-checkbox:checked');
        const geoOptions = document.querySelectorAll('.geo-option-checkbox:checked');

        if (features.length === 0) {
            e.preventDefault();
            alert('Selecteer a.u.b. ten minste één eigenschap voor deze woning');
            return false;
        }

        if (geoOptions.length === 0) {
            e.preventDefault();
            alert('Selecteer a.u.b. ten minste één locatie optie voor deze woning');
            return false;
        }

        if (selectedFiles.length === 0) {
            e.preventDefault();
            alert('Upload a.u.b. ten minste één afbeelding voor deze woning');
            return false;
        }

    });
</script>

@endsection
