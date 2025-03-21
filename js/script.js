// Initialize AOS
AOS.init({
    duration: 1000,
    once: true
});

// Hamburger Menu Toggle
const menuToggle = document.querySelector('.menu-toggle');
const nav = document.querySelector('.nav');
menuToggle.addEventListener('click', () => {
    nav.classList.toggle('active');
});

// Testimonial Slider Logic
const wrapper = document.querySelector('.testimonial-wrapper');
const items = document.querySelectorAll('.testimonial-item');
const totalItems = items.length;
let currentIndex = 0;

// Function to update slider position
function updateSlider() {
    wrapper.style.transform = `translateX(-${currentIndex * 100}%)`;
}

// Auto-slide every 4 seconds
let autoSlide = setInterval(() => {
    currentIndex = (currentIndex + 1) % totalItems;
    updateSlider();
}, 4000);


// Restart auto-slide after manual interaction
function restartAutoSlide() {
    autoSlide = setInterval(() => {
        currentIndex = (currentIndex + 1) % totalItems;
        updateSlider();
    }, 4000);
}

