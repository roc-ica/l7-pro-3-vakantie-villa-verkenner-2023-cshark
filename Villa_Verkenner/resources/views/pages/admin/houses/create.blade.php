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
        <form action="{{ route('admin.houses.store') }}" method="POST" enctype="multipart/form-data" class="admin-form">
            @csrf
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Naam Woning <span class="required">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="price">Prijs (€) <span class="required">*</span></label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" required min="25000" max="2000000" step="0.01">
                    @error('price')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="rooms">Aantal Kamers <span class="required">*</span></label>
                    <input type="number" id="rooms" name="rooms" value="{{ old('rooms') }}" required min="1" max="20" step="1">
                    @error('rooms')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="status">Status Woning <span class="required">*</span></label>
                    <select id="status" name="status" required>
                        <option value="Beschikbaar" {{ old('status') == 'Beschikbaar' ? 'selected' : '' }}>Beschikbaar</option>
                        <option value="Verkocht" {{ old('status') == 'Verkocht' ? 'selected' : '' }}>Verkocht</option>
                    </select>
                    @error('status')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="popular">Populaire Woning <span class="required">*</span></label>
                    <select id="popular" name="popular" required>
                        <option value="0" {{ old('popular') == '0' ? 'selected' : '' }}>Niet Populair</option>
                        <option value="1" {{ old('popular') == '1' ? 'selected' : '' }}>Populair</option>
                    </select>
                    @error('popular')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group full-width">
                    <label for="address">Adres <span class="required">*</span></label>
                    <input type="text" id="address" name="address" value="{{ old('address') }}" required>
                    @error('address')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group full-width">
                    <label for="description">Beschrijving <span class="required">*</span></label>
                    <textarea id="description" name="description" rows="5" required maxlength="5000">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="error">{{ $message }}</span>
                    @enderror
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
                    <p class="help-text">De eerste afbeelding wordt automatisch de primaire afbeelding. U kunt maximaal 5 afbeeldingen uploaden.</p>
                    <div id="image-preview-container" class="image-previews"></div>
                    @error('images')
                        <span class="error">{{ $message }}</span>
                    @enderror
                    @error('images.*')
                        <span class="error">{{ $message }}</span>
                    @enderror
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
                    @error('features')
                        <span class="error">{{ $message }}</span>
                    @enderror
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
                    @error('geo_options')
                        <span class="error">{{ $message }}</span>
                    @enderror
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

<script>
    document.getElementById('images').addEventListener('change', function(e) {
        const files = e.target.files;
        const fileCount = files.length;
        
        if (fileCount === 0) {
            document.querySelector('.files-selected').textContent = 'Geen bestanden gekozen';
        } else if (fileCount > 5) {
            document.querySelector('.files-selected').textContent = 'Te veel bestanden gekozen (max 5)';
            this.value = '';
            return;
        } else {
            document.querySelector('.files-selected').textContent = `${fileCount} ${fileCount === 1 ? 'bestand' : 'bestanden'} gekozen`;
        }
        
        const previewContainer = document.getElementById('image-preview-container');
        previewContainer.innerHTML = '';
        
        for (let i = 0; i < Math.min(files.length, 5); i++) {
            const file = files[i];
            const reader = new FileReader();
            
            reader.onload = function(event) {
                const previewDiv = document.createElement('div');
                previewDiv.className = 'image-preview';
                
                if (i === 0) {
                    previewDiv.classList.add('primary-image');
                    previewDiv.innerHTML = `
                        <div class="primary-badge">Primair</div>
                        <img src="${event.target.result}" alt="Preview">
                    `;
                } else {
                    previewDiv.innerHTML = `<img src="${event.target.result}" alt="Preview">`;
                }
                
                previewContainer.appendChild(previewDiv);
            };
            
            reader.readAsDataURL(file);
        }
    });

    document.querySelector('form.admin-form').addEventListener('submit', function(e) {
        const features = document.querySelectorAll('.feature-checkbox:checked');
        if (features.length === 0) {
            e.preventDefault();
            alert('Selecteer a.u.b. ten minste één eigenschap voor deze woning');
            document.querySelector('.form-section:nth-child(1)').scrollIntoView({ behavior: 'smooth' });
            return false;
        }
        
        const geoOptions = document.querySelectorAll('.geo-option-checkbox:checked');
        if (geoOptions.length === 0) {
            e.preventDefault();
            alert('Selecteer a.u.b. ten minste één locatie optie voor deze woning');
            document.querySelector('.form-section:nth-child(2)').scrollIntoView({ behavior: 'smooth' });
            return false;
        }
        
        const images = document.getElementById('images').files;
        if (images.length === 0) {
            e.preventDefault();
            alert('Upload a.u.b. ten minste één afbeelding voor deze woning');
            document.getElementById('images').scrollIntoView({ behavior: 'smooth' });
            return false;
        }
    });
</script>
@endsection