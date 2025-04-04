<x-layout title="Detail">
  <main class="detail-main" 
        data-images='["https://picsum.photos/id/53/1200/700", 
                      "https://picsum.photos/id/22/2000", 
                      "https://picsum.photos/id/310/2000", 
                      "https://picsum.photos/id/237/1200/700", 
                      "https://picsum.photos/id/239/1200/700"]'>
    <div class="house-container">
      <div class="image-container">
        <div class="left-side-image">
          <img src="https://picsum.photos/id/53/1200/700" alt="image">
        </div>
        <div class="sides-image">
          <button id="seeMoreBtnDetail" class="see-more-btn">See More</button>
          <div class="top-right-image">
            <img src="https://picsum.photos/id/22/2000" alt="image">
          </div>
          <div class="bottom-right-image">
            <img src="https://picsum.photos/id/310/2000" alt="image">
          </div>
        </div>
      </div>
      <div class="text-container">
        <h1 class="house-title">Title van het huis</h1>
        <p class="place">plaatsnaam en plaatsnaam</p>
        <p class="area-surroundings">liggingsopties</p>
        <div class="price">
          <img src="{{ asset('images/verf/verf_donkerpaars1.png') }}" alt="image">
          <span>€150.000</span>
        </div>
      </div>
    </div>

    <div class="description-container">
      <h1 class="description-title">beschrijving</h1>
      <p class="description-paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus beatae deserunt, eligendi debitis ratione hic soluta quidem, temporibus dolorum dignissimos, veritatis eveniet similique expedita ipsam aliquid? Voluptatibus aut soluta et consectetur veniam minima quas doloremque, culpa, fuga dignissimos qui, tempora porro debitis voluptatem molestias? Possimus accusamus quam sequi maiores eos nam nihil quaerat tempore similique illum optio magnam autem nostrum inventore excepturi, quia quo quidem iste enim voluptate dicta facilis minus asperiores. Hic porro aliquid itaque dolorem doloribus eos assumenda nobis? Aperiam sint incidunt mollitia ipsam quis illum facere temporibus repellendus consequuntur natus neque qui vitae molestiae alias cum reprehenderit cumque, in veritatis quae praesentium! Commodi cum modi, tempora alias vero amet inventore deleniti a quos! Mollitia, voluptatibus excepturi pariatur rerum unde architecto iste, veritatis, cumque dolorem sunt obcaecati consequatur maxime fugiat quia. Facilis recusandae dignissimos beatae accusantium adipisci explicabo architecto! Repudiandae natus commodi tempore cumque deserunt fugiat eligendi quae? Maiores molestias perferendis, nulla numquam voluptas repellat molestiae cumque. Mollitia hic facilis autem temporibus debitis deleniti, porro quo magnam ipsam vero animi possimus expedita maxime omnis. Quaerat iusto quam nemo in et tempore voluptatem fugit reiciendis itaque quae. Eius commodi corrupti odio libero rem suscipit iste quisquam veniam rerum nulla!</p>
      <div class="more-btns">
        <div class="more-info-btn" id="moreInfoBtn">
          <img src="{{ asset('images/verf/verf_donkerpaars1.png') }}" alt="image">
          <span>More Info</span>
        </div>
        <div class="pdf-btn">
            <img src="{{ asset('images/verf/verf_lichtpaars.webp') }}" alt="image">
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
    <form action="" class="send-info-form">
      <i class="fa-solid fa-sharp fa-xmark close-btn-info" id="closeSendInfoBtn"></i>
      <h2>More Info</h2>
      <input type="email" placeholder="Enter Your email" required>
      <textarea placeholder="Enter your message" name="info-description" id="infoDescription" rows="10"></textarea>
      <button class="send-info-btn">Send</button>
    </form>
  </div>
</x-layout>