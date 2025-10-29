// JavaScript code for interactivity on the website

// Slider functionality
let currentSlide = 0;
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;

function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.classList.toggle('active', i === index);
    });
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    showSlide(currentSlide);
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    showSlide(currentSlide);
}

function currentSlideFunc(n) {
    currentSlide = n - 1;
    showSlide(currentSlide);
}

// Event listeners for slider buttons
document.querySelector('.next-btn').addEventListener('click', nextSlide);
document.querySelector('.prev-btn').addEventListener('click', prevSlide);

// Event listeners for testimonial controls
document.querySelector('.testimonial-next').addEventListener('click', () => {
    // Logic for next testimonial
});

document.querySelector('.testimonial-prev').addEventListener('click', () => {
    // Logic for previous testimonial
});

// Back to top button functionality
const backToTopButton = document.getElementById('backToTop');

window.onscroll = function() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        backToTopButton.style.display = "block";
    } else {
        backToTopButton.style.display = "none";
    }
};

backToTopButton.addEventListener('click', () => {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
});