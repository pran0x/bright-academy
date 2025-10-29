// DOM Content Loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all functions
    initMobileMenu();
    initSlider();
    initTestimonialsSlider();
    initScrollEffects();
    initSmoothScrolling();
    initFormHandling();
    initAdmissionForm();
    initBackToTop();
    initAnimations();
    initCounters();
});

// Mobile Navigation Menu
function initMobileMenu() {
    const navToggle = document.getElementById('nav-toggle');
    const navMenu = document.getElementById('nav-menu');
    const navLinks = document.querySelectorAll('.nav-link');

    if (!navToggle || !navMenu) return;

    // Toggle mobile menu
    navToggle.addEventListener('click', function() {
        navMenu.classList.toggle('active');
        navToggle.classList.toggle('active');
    });

    // Close menu when clicking on a link
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            navMenu.classList.remove('active');
            navToggle.classList.remove('active');
            
            // Update active link
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!navToggle.contains(e.target) && !navMenu.contains(e.target)) {
            navMenu.classList.remove('active');
            navToggle.classList.remove('active');
        }
    });
}

// Hero Slider Functionality
let currentSlide = 0;
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');
const totalSlides = slides.length;

function initSlider() {
    if (totalSlides === 0) return;
    
    // Auto slide every 5 seconds
    setInterval(nextSlide, 5000);
    
    // Initialize first slide
    updateSlider();
}

function showSlide(index) {
    // Hide all slides
    slides.forEach(slide => slide.classList.remove('active'));
    dots.forEach(dot => dot.classList.remove('active'));
    
    // Show current slide
    if (slides[index]) slides[index].classList.add('active');
    if (dots[index]) dots[index].classList.add('active');
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    showSlide(currentSlide);
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    showSlide(currentSlide);
}

function currentSlideFunc(index) {
    currentSlide = index - 1;
    showSlide(currentSlide);
}

function updateSlider() {
    showSlide(currentSlide);
}

// Smooth Scrolling for Navigation Links
function initSmoothScrolling() {
    const navLinks = document.querySelectorAll('a[href^="#"]');
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                const header = document.querySelector('.header');
                const headerHeight = header ? header.offsetHeight : 0;
                const targetPosition = targetSection.offsetTop - headerHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Scroll Effects and Active Navigation
function initScrollEffects() {
    const header = document.querySelector('.header');
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link');
    
    if (!header) return;
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset;
        
        // Header background on scroll
        if (scrollTop > 100) {
            header.style.background = 'linear-gradient(135deg, rgba(220, 38, 38, 0.95), rgba(185, 28, 28, 0.95))';
            header.style.backdropFilter = 'blur(10px)';
        } else {
            header.style.background = 'linear-gradient(135deg, #dc2626, #b91c1c)';
            header.style.backdropFilter = 'none';
        }
        
        // Active navigation based on scroll position
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 150;
            const sectionHeight = section.clientHeight;
            
            if (scrollTop >= sectionTop && scrollTop < sectionTop + sectionHeight) {
                current = section.getAttribute('id');
            }
        });
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${current}`) {
                link.classList.add('active');
            }
        });
    });
}

// Back to Top Button
function initBackToTop() {
    const backToTopBtn = document.getElementById('backToTop');
    
    if (!backToTopBtn) return;
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopBtn.classList.add('show');
        } else {
            backToTopBtn.classList.remove('show');
        }
    });
    
    backToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// Testimonials Slider Functionality
let currentTestimonial = 0;
const testimonialItems = document.querySelectorAll('.testimonial-item');
const totalTestimonials = testimonialItems.length;

function initTestimonialsSlider() {
    if (totalTestimonials === 0) return;
    
    // Auto slide every 6 seconds
    setInterval(nextTestimonial, 6000);
    
    // Initialize controls
    const prevBtn = document.querySelector('.testimonial-prev');
    const nextBtn = document.querySelector('.testimonial-next');
    
    if (prevBtn) {
        prevBtn.addEventListener('click', prevTestimonial);
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', nextTestimonial);
    }
    
    // Initialize first testimonial
    updateTestimonialSlider();
}

function showTestimonial(index) {
    testimonialItems.forEach(item => item.classList.remove('active'));
    if (testimonialItems[index]) {
        testimonialItems[index].classList.add('active');
    }
}

function nextTestimonial() {
    currentTestimonial = (currentTestimonial + 1) % totalTestimonials;
    showTestimonial(currentTestimonial);
}

function prevTestimonial() {
    currentTestimonial = (currentTestimonial - 1 + totalTestimonials) % totalTestimonials;
    showTestimonial(currentTestimonial);
}

function updateTestimonialSlider() {
    showTestimonial(currentTestimonial);
}

// Form Handling
function initFormHandling() {
    const contactForm = document.querySelector('.contact-form form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const name = this.querySelector('input[type="text"]').value;
            const email = this.querySelector('input[type="email"]').value;
            const phone = this.querySelector('input[type="tel"]').value;
            
            // Basic validation
            if (!name || !email || !phone) {
                alert('অনুগ্রহ করে সকল প্রয়োজনীয় তথ্য পূরণ করুন।');
                return;
            }
            
            // Add loading state
            const submitBtn = this.querySelector('.submit-btn');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'পাঠানো হচ্ছে...';
            submitBtn.disabled = true;
            submitBtn.classList.add('loading');
            
            // Simulate form submission
            setTimeout(() => {
                alert('আপনার বার্তা সফলভাবে পাঠানো হয়েছে! আমরা শীঘ্রই আপনার সাথে যোগাযোগ করব।');
                this.reset();
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
                submitBtn.classList.remove('loading');
                
                // Track form submission
                trackEvent('form_submission', {
                    form_type: 'contact',
                    page: window.location.pathname
                });
            }, 2000);
        });
    }
}

// Admission Form Handling
function initAdmissionForm() {
    const admissionForm = document.getElementById('admissionForm');
    
    if (admissionForm) {
        admissionForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const studentName = formData.get('student_name');
            const className = formData.get('class');
            const phone = formData.get('phone');
            const fatherName = formData.get('father_name');
            const motherName = formData.get('mother_name');
            
            // Validation
            if (!studentName || !className || !phone || !fatherName || !motherName) {
                alert('অনুগ্রহ করে সকল প্রয়োজনীয় (*) ক্ষেত্র পূরণ করুন।');
                return;
            }
            
            // Phone validation
            const phonePattern = /^01[3-9]\d{8}$/;
            if (!phonePattern.test(phone.replace(/\D/g, ''))) {
                alert('অনুগ্রহ করে সঠিক মোবাইল নম্বর দিন (01xxxxxxxxx)।');
                return;
            }
            
            // Add loading state
            const submitBtn = this.querySelector('.admission-submit-btn');
            const originalHTML = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> প্রক্রিয়াকরণ করা হচ্ছে...';
            submitBtn.disabled = true;
            
            // Simulate form submission
            setTimeout(() => {
                alert(`ধন্যবাদ! ${studentName} এর ভর্তি আবেদন সফলভাবে জমা দেওয়া হয়েছে। আমরা শীঘ্রই আপনার সাথে যোগাযোগ করব।`);
                this.reset();
                submitBtn.innerHTML = originalHTML;
                submitBtn.disabled = false;
                
                // Track admission form submission
                trackEvent('admission_form_submission', {
                    student_name: studentName,
                    class: className,
                    page: window.location.pathname
                });
            }, 3000);
        });
    }
}

// Scroll Animations
function initAnimations() {
    if (!('IntersectionObserver' in window)) return;
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);
    
    // Add animation classes to elements
    const animateElements = document.querySelectorAll('.course-card, .stat-item, .gallery-item, .contact-item, .faculty-card, .news-card, .testimonial-content');
    animateElements.forEach(el => {
        el.classList.add('fade-in');
        observer.observe(el);
    });
}

// Counter Animation for Statistics
function animateCounter(element, target, duration = 2000) {
    if (!element) return;
    
    let current = 0;
    const increment = target / (duration / 16);
    const hasPlus = target.toString().includes('+');
    const hasPercent = target.toString().includes('%');
    const numericTarget = parseInt(target.toString().replace(/[+%]/g, ''));
    
    const timer = setInterval(() => {
        current += increment;
        if (current >= numericTarget) {
            current = numericTarget;
            clearInterval(timer);
        }
        
        let displayValue = Math.floor(current);
        if (hasPlus) displayValue += '+';
        if (hasPercent) displayValue += '%';
        
        element.textContent = displayValue;
    }, 16);
}

// Initialize counters when stats section is visible
function initCounters() {
    const statsSection = document.querySelector('.about-stats');
    if (!statsSection) return;
    
    let countersStarted = true;
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting && !countersStarted) {
                countersStarted = true;
                
                const counters = [
                    { element: document.querySelector('.stat-item:nth-child(1) .stat-number'), target: '3000+' },
                    { element: document.querySelector('.stat-item:nth-child(2) .stat-number'), target: '17+' },
                    { element: document.querySelector('.stat-item:nth-child(3) .stat-number'), target: '45+' },
                    { element: document.querySelector('.stat-item:nth-child(4) .stat-number'), target: '100%' }
                ];
                
                counters.forEach(counter => {
                    if (counter.element) {
                        animateCounter(counter.element, counter.target);
                    }
                });
            }
        });
    }, { threshold: 0.5 });
    
    observer.observe(statsSection);
}

// Utility Functions
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Optimized scroll handler
const optimizedScrollHandler = debounce(function() {
    // Any expensive scroll operations can go here
}, 10);

window.addEventListener('scroll', optimizedScrollHandler);

// Keyboard Navigation Support
document.addEventListener('keydown', function(e) {
    // Escape key closes mobile menu
    if (e.key === 'Escape') {
        const navMenu = document.getElementById('nav-menu');
        const navToggle = document.getElementById('nav-toggle');
        if (navMenu && navToggle) {
            navMenu.classList.remove('active');
            navToggle.classList.remove('active');
        }
    }
    
    // Arrow keys for slider navigation
    if (e.key === 'ArrowLeft') {
        prevSlide();
    } else if (e.key === 'ArrowRight') {
        nextSlide();
    }
});

// Touch/Swipe Support for Slider
let touchStartX = 0;
let touchEndX = 0;

const heroSlider = document.querySelector('.hero-slider');
if (heroSlider) {
    heroSlider.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    heroSlider.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, { passive: true });
}

function handleSwipe() {
    const swipeThreshold = 50;
    const diff = touchStartX - touchEndX;
    
    if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
            nextSlide();
        } else {
            prevSlide();
        }
    }
}

// Error Handling for Images
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.addEventListener('error', function() {
            console.warn('Image failed to load:', this.src);
            // Create a placeholder SVG
            this.src = 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 200"><rect fill="%23f3f4f6" width="300" height="200"/><text x="50%" y="50%" text-anchor="middle" fill="%236b7280" font-family="Arial, sans-serif" font-size="14">ছবি লোড হচ্ছে না</text></svg>';
        });
    });
});

// Performance Optimization
if ('IntersectionObserver' in window) {
    // Use Intersection Observer for better performance
    const lazyImages = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                imageObserver.unobserve(img);
            }
        });
    });
    
    lazyImages.forEach(img => imageObserver.observe(img));
}

// Local Storage for User Preferences
function saveUserPreference(key, value) {
    try {
        localStorage.setItem(`brightacademic_${key}`, JSON.stringify(value));
    } catch (e) {
        console.warn('Local storage not available');
    }
}

function getUserPreference(key, defaultValue) {
    try {
        const stored = localStorage.getItem(`brightacademic_${key}`);
        return stored ? JSON.parse(stored) : defaultValue;
    } catch (e) {
        return defaultValue;
    }
}

// Analytics Tracking (placeholder for future implementation)
function trackEvent(eventName, eventData = {}) {
    // This would integrate with Google Analytics or other tracking services
    console.log('Event tracked:', eventName, eventData);
}

// Track navigation clicks
document.addEventListener('click', function(e) {
    if (e.target.matches('.nav-link')) {
        trackEvent('navigation_click', {
            link_text: e.target.textContent.trim(),
            destination: e.target.getAttribute('href')
        });
    }
    
    if (e.target.matches('.cta-button')) {
        trackEvent('cta_click', {
            button_text: e.target.textContent.trim(),
            page: window.location.pathname
        });
    }
});

// Phone number click tracking
document.addEventListener('click', function(e) {
    if (e.target.textContent && e.target.textContent.match(/০১৭\d{8}/)) {
        trackEvent('phone_click', {
            phone_number: e.target.textContent.trim()
        });
    }
});

// Initialize running banner animation restart on visibility change
document.addEventListener('visibilitychange', function() {
    if (!document.hidden) {
        const bannerContent = document.querySelector('.banner-content');
        if (bannerContent) {
            bannerContent.style.animation = 'none';
            bannerContent.offsetHeight; // Trigger reflow
            bannerContent.style.animation = 'scroll-left 20s linear infinite';
        }
    }
});

// Console branding
console.log('%cব্রাইট একাডেমিক কেয়ার', 'color: #dc2626; font-size: 24px; font-weight: bold;');
console.log('%cWebsite developed with care and attention to detail', 'color: #6b7280; font-size: 14px;');

// Service Worker Registration for PWA capabilities (future enhancement)
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        // Service worker would go here for offline functionality
    });
}