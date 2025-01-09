
class Carousel {
  currentIndex = 0

  /**
   * @param {string} wrapperID
   */
  constructor(wrapperID) {
    this.wrapper = document.getElementById(wrapperID)
    this.itemsWrapper = /** @type {HTMLElement} */ (this.wrapper.getElementsByClassName('carousel-items')[0])
    this.items = this.wrapper.getElementsByClassName('carousel-item')

    this.#addEventListeners()
  }

  prev() {
    this.currentIndex = this.currentIndex > 0 ? this.currentIndex - 1 : this.items.length - 1
    this.#update()
  }

  next() {
    this.currentIndex = (this.currentIndex < this.items.length - 1)? this.currentIndex + 1 : 0
    this.#update()
  }

  #update() {
    const translateX = -this.currentIndex * 100
    this.itemsWrapper.style.transform = `translateX(${translateX}%)`
  }

  #addEventListeners() {
    this.prevButton = this.wrapper.getElementsByClassName('prev')[0]
    this.nextButton = this.wrapper.getElementsByClassName('next')[0]

    this.prevButton.addEventListener('click', e => this.prev())
    this.nextButton.addEventListener('click', e => this.next())
  }
}
