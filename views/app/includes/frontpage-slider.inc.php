<style>
  /* Adjust slider height */
  #heroCarousel .carousel-item img,
  #heroCarousel .carousel-item video {
    height: 680px;
    /* set your preferred height */
    object-fit: cover;
    /* crop nicely instead of stretching */
  }

  @media screen and (max-width: 768px) {

    #heroCarousel .carousel-item img,
    #heroCarousel .carousel-item video {
      height: 500px;
      /* adjust height for smaller screens */
    }

  }

  /* Optional: make video not overflow */

  .margin-giving {
    margin-top: 85px !important;
  }
</style>

<section class="slider-content mt-5 d-flex align-items-center justify-content-start p-0 margin-giving">
  <div class="container-fluid p-0">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
      <div class="carousel-inner">

        <!-- Slide 1: Image -->
        <div class="carousel-item active">
          <a href="<?= $url->baseUrl("shop") ?>">
            <picture>
              <!-- Mobile image -->
              <source media="(max-width: 768px)"
                srcset="<?= $url->baseUrl("views/app/assets/images/Mobile_Banner.jpg") ?>">
              <!-- Default / Desktop image -->
              <img src="<?= $url->baseUrl("views/app/assets/images/Desktop_Banner.jpg") ?>" class="d-block w-100"
                alt="Leather Bag">
            </picture>
          </a>
        </div>

        <!-- Slide 2: Video -->
        <div class="carousel-item">
          <video class="d-block w-100 " autoplay muted loop>
            <source src="<?= $url->baseUrl("views/app/assets/video/bannervideo.mp4") ?>" type="video/mp4">
            Your browser does not support the video tag.
          </video>
        </div>

      </div>

      <!-- Controls -->
      <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>
  </div>
</section>