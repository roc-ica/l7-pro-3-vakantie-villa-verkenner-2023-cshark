<x-layout title="{{ $house->name }}">
    <main class="detail-main"
        data-images='{{ json_encode($house->images->pluck('image_path')->map(function ($path) {return asset('storage/' . $path);})) }}'>
        
        @if(session('success'))
        <div class="success-message">
            <i class="fa-solid fa-check-circle"></i>
            {{ session('success') }}
            <button class="close-message"><i class="fa-solid fa-times"></i></button>
        </div>
        @endif
        
        <div class="house-container">
            <div class="image-container">
                <div class="left-side-image">
                    <img src="{{ asset('storage/' . $house->primary_image) }}" alt="{{ $house->name }}"
                        onerror="this.src='{{ asset('storage/houses/defaultImage.webp') }}'">
                </div>
                <div class="sides-image">
                    <button id="seeMoreBtnDetail" class="see-more-btn">Bekijk meer</button>
                    <div class="top-right-image">
                        @if ($house->images->where('is_primary', false)->count() > 0)
                            <img src="{{ asset('storage/' . $house->images->where('is_primary', false)->first()->image_path) }}"
                                alt="{{ $house->name }}"
                                onerror="this.src='{{ asset('storage/houses/defaultImage.webp') }}'">
                        @else
                            <img src="{{ asset('storage/houses/defaultImage.webp') }}" alt="{{ $house->name }}">
                        @endif
                    </div>
                    <div class="bottom-right-image">
                        @if ($house->images->where('is_primary', false)->count() > 1)
                            <img src="{{ asset('storage/' . $house->images->where('is_primary', false)->skip(1)->first()->image_path) }}"
                                alt="{{ $house->name }}"
                                onerror="this.src='{{ asset('storage/houses/defaultImage.webp') }}'">
                        @else
                            <img src="{{ asset('storage/houses/defaultImage.webp') }}" alt="{{ $house->name }}">
                        @endif
                    </div>
                </div>
            </div>
            <div class="text-container">
                <h1 class="house-title">{{ $house->name }}</h1>
                <p class="place">{{ $house->address }}</p>
                <p class="area-surroundings">
                    @if ($house->geoOptions->isNotEmpty())
                        {{ $house->geoOptions->pluck('name')->implode(', ') }}
                    @endif
                </p>
                <div class="price">
                    <img src="{{ asset('images/verf/verf_lichtpaars3.png') }}" alt="prijs">
                    <span>€{{ number_format($house->price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="description-container">
            <h1 class="description-title">Beschrijving</h1>
            <p class="description-paragraph">{{ $house->description }}</p>

            <div class="house-features">
                <h2>Kenmerken</h2>
                <div class="features-grid">
                    @if ($house->features->isNotEmpty())
                        @foreach ($house->features as $feature)
                            <div class="feature-item">
                                <strong>{{ $feature->name }}</strong>
                            </div>
                        @endforeach
                    @endif
                    <div class="feature-item">
                        <strong>Slaapkamers:</strong> {{ $house->rooms }}
                    </div>
                    <div class="feature-item">
                        <strong>Status:</strong> {{ $house->status }}
                    </div>

                </div>
            </div>

            <div class="more-btns">
                <div class="more-info-btn" id="moreInfoBtn">
                    <img src="{{ asset('images/verf/verf_blauw1.png') }}" alt="meer info">
                    <span>Meer Info</span>
                </div>
                <div class="pdf-btn">
                    <img src="{{ asset('images/verf/verf_blauw1.png') }}" alt="pdf">
                    <span>PDF</span>
                </div>
            </div>
        </div>
    </main>

    <div class="image-slider-popup" id="imageSliderPopup">
        <div class="image-slider-content">
            <button id="closePopupBtn" class="close-popup-btn">&times;</button>
            <div class="slider-controls">
                <button id="prevSlide" class="slider-btn"><i class="fa-solid fa-chevron-left"></i></button>
                <div class="slider-image-container">
                    <img id="sliderImage" src="" alt="Slider Image">
                </div>
                <button id="nextSlide" class="slider-btn"><i class="fa-solid fa-chevron-right"></i></button>
            </div>
        </div>
    </div>

    <div class="send-info-modual" id="sendInfoModual">
        <form action="{{ route('contact.send-info', $house->id) }}" method="POST"
            class="send-info-form admin-style-form">
            @csrf
            <i class="fa-solid fa-sharp fa-xmark close-btn-info" id="closeSendInfoBtn"></i>
            <h2>Wilt u meer informatie?</h2>

            <div class="form-group">
                <label for="email">E-mail <span class="required">*</span></label>
                <input type="email" id="email" name="email" placeholder="Uw e-mailadres" required>
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="message">Bericht <span class="required">*</span></label>
                <textarea placeholder="Uw bericht" name="message" id="message" rows="7" required></textarea>
                @error('message')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <input type="hidden" name="house_id" value="{{ $house->id }}">
            <input type="hidden" name="house_name" value="{{ $house->name }}">

            <button type="submit" class="send-info-btn">
                <i class="fa-solid fa-paper-plane"></i> Versturen
            </button>
        </form>
    </div>

    <script>
        // Add JavaScript to handle the close button for the success message
        document.addEventListener('DOMContentLoaded', function() {
            const closeButtons = document.querySelectorAll('.close-message');
            closeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const messageElement = this.parentElement;
                    messageElement.style.opacity = '0';
                    setTimeout(() => {
                        messageElement.style.display = 'none';
                    }, 300);
                });
            });
            
            // Auto-hide success message after 5 seconds
            const successMessage = document.querySelector('.success-message');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.opacity = '0';
                    setTimeout(() => {
                        successMessage.style.display = 'none';
                    }, 300);
                }, 5000);
            }
        });
    </script>

    <style>
        .success-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: rgba(40, 167, 69, 0.9);
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: 400px;
            animation: slideIn 0.3s ease;
            transition: opacity 0.3s ease;
        }
        
        .success-message i {
            font-size: 18px;
        }
        
        .close-message {
            margin-left: auto;
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 0;
            font-size: 14px;
            opacity: 0.7;
            transition: opacity 0.2s;
        }
        
        .close-message:hover {
            opacity: 1;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(100px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
</x-layout>
