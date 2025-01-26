let currentSlide = 0;
const totalSlides = 4;
const track = document.querySelector(".quotes-track");
const dots = document.querySelectorAll(".dots-nav .dot");

function updateSlidePosition() {
  track.style.transform = `translateX(-${currentSlide * 100}%)`;
  // Update dots
  dots.forEach((dot, index) => {
    dot.classList.toggle("active", index === currentSlide);
  });
}

function moveSlide(direction) {
  currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
  updateSlidePosition();
}

function goToSlide(slideIndex) {
  currentSlide = slideIndex;
  updateSlidePosition();
}

// Auto-advance slides
setInterval(() => moveSlide(1), 5000);