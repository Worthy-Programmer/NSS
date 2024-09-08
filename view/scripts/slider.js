let currentIndex = 0;

function movePrev() {
  const carousel = document.querySelector('.carousel-items');
  if (currentIndex > 0) {
    currentIndex--;
  }
  updateCarousel(carousel);
}

function moveNext() {
  const carousel = document.querySelector('.carousel-items');
  const items = document.querySelectorAll('.carousel-item').length;
  if (currentIndex < items - 1) {
    currentIndex++;
  }
  updateCarousel(carousel);
}

function updateCarousel(carousel) {
  const translateX = -currentIndex * 100;
  carousel.style.transform = `translateX(${translateX}%)`;
}
