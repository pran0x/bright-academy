# ব্রাইট একাডেমিক কেয়ার - কোচিং সেন্টার

## Overview

This is a comprehensive Bengali educational website for "Bright Academic Care" (ব্রাইট একাডেমিক কেয়ার), a coaching center in Bangladesh. The site serves as a complete promotional and enrollment platform for prospective students and parents, featuring course information, faculty profiles, student testimonials, news updates, online admission form, and contact details. The website is designed to be fully responsive and accessible, with Bengali language support and modern interactive features.

## User Preferences

Preferred communication style: Simple, everyday language.

## System Architecture

### Frontend Architecture
- **Static Website Structure**: Built as a traditional multi-page website using vanilla HTML, CSS, and JavaScript
- **Language Support**: Primary focus on Bengali language with proper font integration (Noto Sans Bengali, Roboto)
- **Responsive Design**: Mobile-first approach with responsive navigation and layout components
- **Component-Based Styling**: Organized CSS architecture with separate main.css file for maintainability

### UI/UX Design Patterns
- **Running Banner**: Animated promotional banner for announcements and contact information
- **Navigation System**: Mobile-responsive navigation with hamburger menu and smooth scrolling (8 sections: Home, Testimonials, About, Faculty, Courses, News, Gallery, Admission, Contact)
- **Interactive Elements**: Hero slider, testimonials slider with auto-advance, scroll effects, form handling, counter animations, and news cards
- **Visual Hierarchy**: Gradient backgrounds, proper typography, consistent spacing using container-based layouts, and hover effects
- **Student Testimonials**: Interactive testimonial slider with navigation controls and auto-advance functionality
- **Faculty Profiles**: Grid-based faculty cards with photos, qualifications, and experience details
- **News & Announcements**: Dynamic news section with featured articles and categorized badges
- **Online Admission System**: Comprehensive admission form with validation and submission handling

### JavaScript Architecture
- **Modular Functions**: Separate initialization functions for different features (mobile menu, hero slider, testimonials slider, scroll effects, contact forms, admission form)
- **Event-Driven Programming**: DOM content loaded event handling with proper event listeners
- **Progressive Enhancement**: Graceful degradation with feature detection before initialization
- **Form Validation**: Client-side validation for both contact and admission forms with user feedback
- **Slider Management**: Auto-advancing testimonials slider with manual navigation controls
- **Interactive Animations**: Intersection Observer API for scroll-triggered animations and counter effects

### Styling System
- **CSS Reset**: Universal box-sizing and margin/padding reset for consistency
- **Custom Properties**: Gradient backgrounds and color schemes for branding
- **Animation System**: CSS keyframe animations for banner scrolling and interactive effects
- **Typography**: Google Fonts integration with fallback fonts for Bengali text rendering

## External Dependencies

### Content Delivery Networks
- **Google Fonts**: Noto Sans Bengali and Roboto font families for proper Bengali text rendering
- **Font Awesome**: Icon library (version 6.4.0) for UI elements and visual enhancements

### Browser APIs
- **DOM Manipulation**: Standard JavaScript DOM APIs for interactive functionality
- **CSS Animations**: Browser-native animation support for visual effects
- **Responsive Design**: CSS media queries and viewport meta tags for mobile optimization

### Asset Management
- **Images**: Local image assets with SVG placeholders for logos and graphics
- **File Structure**: Organized directory structure with separate folders for styles and scripts