<?php
// Initialize session and config
require_once 'config/config.php';
?>
<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ব্রাইট একাডেমিক কেয়ার - শেখা হোক আনন্দে!</title>
    <meta name="description" content="ব্রাইট একাডেমিক কেয়ার - বাংলাদেশের অগ্রণী কোচিং সেন্টার। মানসম্মত শিক্ষা ও যত্নশীল পরিচর্যায় আপনার সন্তানের ভবিষ্যৎ গড়ুন।">
    <meta name="keywords" content="কোচিং সেন্টার, শিক্ষা, একাডেমিক, ব্রাইট একাডেমিক কেয়ার">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'bengali': ['Noto Sans Bengali', 'sans-serif'],
                        'inter': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'primary': {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        },
                        'secondary': {
                            500: '#8b5cf6',
                            600: '#7c3aed',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Noto Sans Bengali', 'Inter', sans-serif;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes gradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .gradient-animate {
            background-size: 200% 200%;
            animation: gradient 15s ease infinite;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top Banner -->
    <div class="bg-gradient-to-r from-purple-600 via-purple-500 to-pink-500 text-white py-3 px-4">
        <div class="max-w-7xl mx-auto flex items-center justify-center gap-4 flex-wrap text-center">
            <span class="text-2xl animate-bounce">🎓</span>
            <span class="font-semibold text-sm md:text-base">নতুন ব্যাচ শুরু হচ্ছে! ভর্তি চলছে। সীমিত আসন।</span>
            <a href="#admission" class="bg-white text-purple-600 px-6 py-2 rounded-full font-bold text-sm hover:bg-gray-100 transition-all transform hover:scale-105 shadow-lg">
                এখনই ভর্তি হন
            </a>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <nav class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <img src="images/LOgo.jpg" alt="ব্রাইট একাডেমিক কেয়ার লোগো" class="h-14 w-14 rounded-full object-cover shadow-md">
                    <div>
                        <h1 class="text-xl font-bold text-blue-600">ব্রাইট একাডেমিক কেয়ার</h1>
                        <p class="text-sm text-gray-600">শেখা হোক আনন্দে!</p>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <ul class="hidden md:flex items-center gap-2">
                    <li><a href="#home" class="px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-gradient-to-r hover:from-purple-600 hover:to-pink-500 hover:text-white transition-all">হোম</a></li>
                    <li><a href="#courses" class="px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-gradient-to-r hover:from-purple-600 hover:to-pink-500 hover:text-white transition-all">কোর্স সমূহ</a></li>
                    <li><a href="#about" class="px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-gradient-to-r hover:from-purple-600 hover:to-pink-500 hover:text-white transition-all">আমাদের সম্পর্কে</a></li>
                    <li><a href="#testimonials" class="px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-gradient-to-r hover:from-purple-600 hover:to-pink-500 hover:text-white transition-all">মতামত</a></li>
                    <li><a href="#gallery" class="px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-gradient-to-r hover:from-purple-600 hover:to-pink-500 hover:text-white transition-all">গ্যালারি</a></li>
                    <li><a href="#contact" class="px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-gradient-to-r hover:from-purple-600 hover:to-pink-500 hover:text-white transition-all">যোগাযোগ</a></li>
                </ul>

                <!-- Actions -->
                <div class="hidden md:flex items-center gap-3">
                    <a href="tel:01716611208" class="flex items-center gap-2 px-4 py-2 border-2 border-blue-600 text-blue-600 rounded-lg font-semibold hover:bg-blue-600 hover:text-white transition-all">
                        <i class="fas fa-phone"></i>
                        <span>১৬৯১০</span>
                    </a>
                    <a href="admin/login.php" class="px-6 py-2 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-lg font-semibold hover:shadow-lg transform hover:scale-105 transition-all">
                        লগ ইন
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4">
                <ul class="flex flex-col gap-2">
                    <li><a href="#home" class="block px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-purple-100 transition-all">হোম</a></li>
                    <li><a href="#courses" class="block px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-purple-100 transition-all">কোর্স সমূহ</a></li>
                    <li><a href="#about" class="block px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-purple-100 transition-all">আমাদের সম্পর্কে</a></li>
                    <li><a href="#testimonials" class="block px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-purple-100 transition-all">মতামত</a></li>
                    <li><a href="#gallery" class="block px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-purple-100 transition-all">গ্যালারি</a></li>
                    <li><a href="#contact" class="block px-4 py-2 rounded-lg font-medium text-gray-700 hover:bg-purple-100 transition-all">যোগাযোগ</a></li>
                    <li><a href="admin/login.php" class="block px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-lg font-semibold text-center">লগ ইন</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <section id="home" class="relative min-h-screen flex items-center overflow-hidden bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
            <!-- Animated Background Circles -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-0 left-0 w-96 h-96 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float"></div>
                <div class="absolute top-0 right-0 w-96 h-96 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float" style="animation-delay: 2s;"></div>
                <div class="absolute bottom-0 left-1/2 w-96 h-96 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-float" style="animation-delay: 4s;"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 py-20 relative z-10">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <!-- Left Content -->
                    <div class="space-y-8">
                        <div class="inline-flex items-center gap-2 bg-gradient-to-r from-yellow-100 to-yellow-200 px-6 py-3 rounded-full shadow-md">
                            <span class="text-2xl">⭐</span>
                            <span class="font-semibold text-yellow-900 text-sm">বাংলাদেশের শ্রেষ্ঠ কোচিং সেন্টার</span>
                        </div>

                        <h1 class="text-5xl md:text-6xl font-extrabold leading-tight">
                            শেখা হোক <span class="bg-gradient-to-r from-purple-600 to-pink-500 bg-clip-text text-transparent">আনন্দে!</span>
                        </h1>

                        <p class="text-lg text-gray-600 leading-relaxed">
                            মানসম্মত শিক্ষা ও যত্নশীল পরিচর্যায় আপনার সন্তানের উজ্জ্বল ভবিষ্যৎ গড়ুন। 
                            দেশসেরা শিক্ষকদের সাথে অনলাইন ও অফলাইন উভয় মাধ্যমে শিখুন।
                        </p>

                        <div class="flex flex-wrap gap-4">
                            <a href="#admission" class="group relative px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-xl font-semibold text-lg shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all flex items-center gap-2">
                                <span>এখনই ভর্তি হন</span>
                                <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                            </a>
                            <a href="#courses" class="px-8 py-4 bg-white border-2 border-purple-600 text-purple-600 rounded-xl font-semibold text-lg hover:bg-purple-50 transition-all flex items-center gap-2">
                                <i class="fas fa-play-circle"></i>
                                <span>ফ্রি ক্লাস দেখুন</span>
                            </a>
                        </div>

                        <!-- Stats -->
                        <div class="flex flex-wrap gap-8 pt-4">
                            <div class="text-center">
                                <div class="text-4xl font-extrabold bg-gradient-to-r from-purple-600 to-pink-500 bg-clip-text text-transparent counter" data-target="3000" data-suffix="+">০</div>
                                <div class="text-sm text-gray-600 font-medium">সফল শিক্ষার্থী</div>
                            </div>
                            <div class="text-center">
                                <div class="text-4xl font-extrabold bg-gradient-to-r from-purple-600 to-pink-500 bg-clip-text text-transparent counter" data-target="17" data-suffix="+">০</div>
                                <div class="text-sm text-gray-600 font-medium">বছরের অভিজ্ঞতা</div>
                            </div>
                            <div class="text-center">
                                <div class="text-4xl font-extrabold bg-gradient-to-r from-purple-600 to-pink-500 bg-clip-text text-transparent counter" data-target="45" data-suffix="+">০</div>
                                <div class="text-sm text-gray-600 font-medium">অভিজ্ঞ শিক্ষক</div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Image -->
                    <div class="relative">
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                            <img src="images/bannar.jpg" alt="শিক্ষামূলক পরিবেশ" class="w-full h-auto">
                            <!-- Floating Badges -->
                            <div class="absolute top-4 -left-4 bg-white px-4 py-3 rounded-xl shadow-xl animate-float">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-star text-yellow-500 text-xl"></i>
                                    <span class="font-bold"><span class="counter" data-target="100" data-suffix="%">০</span> সফলতার হার</span>
                                </div>
                            </div>
                            <div class="absolute bottom-4 -right-4 bg-white px-4 py-3 rounded-xl shadow-xl animate-float" style="animation-delay: 1.5s;">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-users text-purple-600 text-xl"></i>
                                    <span class="font-bold"><span class="counter" data-target="3000" data-suffix="+">০</span> শিক্ষার্থী</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Class Selection -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">এক জায়গায় সম্পূর্ণ একাডেমিক প্রস্তুতি!</h2>
                    <p class="text-lg text-gray-600">আপনার শ্রেণি নির্বাচন করুন এবং শুরু করুন</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="group relative bg-gradient-to-br from-purple-600 to-purple-700 p-8 rounded-2xl text-white overflow-hidden hover:scale-105 transition-transform cursor-pointer">
                        <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative z-10">
                            <div class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-4">৬-৮</div>
                            <h3 class="text-2xl font-bold text-center mb-2">৬ষ্ঠ, ৭ম, ৮ম শ্রেণি</h3>
                            <div class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-sm font-semibold text-center">২০২৬ সালে ভর্তি চলছে</div>
                        </div>
                    </div>

                    <div class="group relative bg-gradient-to-br from-pink-500 to-rose-600 p-8 rounded-2xl text-white overflow-hidden hover:scale-105 transition-transform cursor-pointer">
                        <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative z-10">
                            <div class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-4">৯-১০</div>
                            <h3 class="text-2xl font-bold text-center mb-2">নবম ও দশম শ্রেণি</h3>
                            <div class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-sm font-semibold text-center">এসএসসি ২০২৬ ও ২০২৭</div>
                        </div>
                    </div>

                    <div class="group relative bg-gradient-to-br from-blue-500 to-cyan-500 p-8 rounded-2xl text-white overflow-hidden hover:scale-105 transition-transform cursor-pointer">
                        <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="relative z-10">
                            <div class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-4">১১-১২</div>
                            <h3 class="text-2xl font-bold text-center mb-2">একাদশ ও দ্বাদশ শ্রেণি</h3>
                            <div class="bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-sm font-semibold text-center">এইচএসসি ২০২৬ ও ২০২৭</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Courses Section -->
        <section id="courses" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">দেশসেরা সকল কোর্স</h2>
                    <p class="text-lg text-gray-600">বিভিন্ন শ্রেণির জন্য বিশেষায়িত কোর্স</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Course Card 1 -->
                    <div class="group bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2">
                        <div class="absolute top-4 right-4 bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-bold">জনপ্রিয়</div>
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl flex items-center justify-center text-white text-3xl mb-4">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray 900 mb-2">প্রাথমিক (১ম - ৫ম শ্রেণি)</h3>
                        <p class="text-gray-600 text-sm mb-4">বাংলা, ইংরেজি, গণিত, বিজ্ঞান ও সামাজিক বিজ্ঞান</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-center gap-2 text-sm text-gray-700">
                                <i class="fas fa-check-circle text-green-500"></i>
                                <span>মৌলিক ধারণা ও ভিত্তি তৈরি</span>
                            </li>
                            <li class="flex items-center gap-2 text-sm text-gray-700">
                                <i class="fas fa-check-circle text-green-500"></i>
                                <span>খেলার ছলে শেখানো</span>
                            </li>
                            <li class="flex items-center gap-2 text-sm text-gray-700">
                                <i class="fas fa-check-circle text-green-500"></i>
                                <span>সৃজনশীল পদ্ধতি</span>
                            </li>
                        </ul>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div>
                                <div class="text-xs text-gray-500">মাসিক ফি</div>
                                <div class="text-lg font-bold text-purple-600">১৫০০-২০০০ টাকা</div>
                            </div>
                            <a href="#admission" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-lg font-semibold text-sm hover:shadow-lg transition-all">
                                ভর্তি হন
                            </a>
                        </div>
                    </div>

                    <!-- Course Card 2 - Featured -->
                    <div class="group bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2 text-white relative overflow-hidden">
                        <div class="absolute top-4 right-4 bg-gradient-to-r from-yellow-200 to-yellow-300 text-yellow-900 px-3 py-1 rounded-full text-xs font-bold">সেরা পছন্দ</div>
                        <div class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-3xl mb-4">
                            <i class="fas fa-book"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">মাধ্যমিক (৬ষ্ঠ - ১০ম শ্রেণি)</h3>
                        <p class="text-white/90 text-sm mb-4">সকল বিষয়ে বিশেষ যত্ন ও JSC/SSC প্রস্তুতি</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start gap-2 text-sm">
                                <i class="fas fa-check-circle text-yellow-300 mt-0.5"></i>
                                <span>বোর্ড পরীক্ষার বিশেষ প্রস্তুতি</span>
                            </li>
                            <li class="flex items-center gap-2 text-sm">
                                <i class="fas fa-check-circle text-yellow-300"></i>
                                <span>সৃজনশীল প্রশ্ন সমাধান</span>
                            </li>
                            <li class="flex items-center gap-2 text-sm">
                                <i class="fas fa-check-circle text-yellow-300"></i>
                                <span>নিয়মিত পরীক্ষা ও মূল্যায়ন</span>
                            </li>
                        </ul>
                        <div class="flex items-center justify-between pt-4 border-t border-white/20">
                            <div>
                                <div class="text-xs text-white/80">মাসিক ফি</div>
                                <div class="text-lg font-bold">২০০০-৩০০০ টাকা</div>
                            </div>
                            <a href="#admission" class="px-4 py-2 bg-white text-purple-600 rounded-lg font-semibold text-sm hover:shadow-lg transition-all">
                                ভর্তি হন
                            </a>
                        </div>
                    </div>

                    <!-- Course Card 3 -->
                    <div class="group bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2">
                        <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">নতুন</div>
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-600 to-cyan-500 rounded-2xl flex items-center justify-center text-white text-3xl mb-4">
                            <i class="fas fa-university"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">উচ্চ মাধ্যমিক (১১শ - ১২শ)</h3>
                        <p class="text-gray-600 text-sm mb-4">বিজ্ঞান, মানবিক ও ব্যবসায় শিক্ষা শাখা</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-center gap-2 text-sm text-gray-700">
                                <i class="fas fa-check-circle text-green-500"></i>
                                <span>HSC পরীক্ষার বিশেষ প্রস্তুতি</span>
                            </li>
                            <li class="flex items-center gap-2 text-sm text-gray-700">
                                <i class="fas fa-check-circle text-green-500"></i>
                                <span>বিষয়ভিত্তিক গভীর পাঠদান</span>
                            </li>
                            <li class="flex items-center gap-2 text-sm text-gray-700">
                                <i class="fas fa-check-circle text-green-500"></i>
                                <span>বিশ্ববিদ্যালয় ভর্তি প্রস্তুতি</span>
                            </li>
                        </ul>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div>
                                <div class="text-xs text-gray-500">মাসিক ফি</div>
                                <div class="text-lg font-bold text-blue-600">৩০০০-৪৫০০ টাকা</div>
                            </div>
                            <a href="#admission" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-lg font-semibold text-sm hover:shadow-lg transition-all">
                                ভর্তি হন
                            </a>
                        </div>
                    </div>

                    <!-- Course Card 4 -->
                    <div class="group bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2">
                        <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center text-white text-3xl mb-4">
                            <i class="fas fa-laptop-code"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">কম্পিউটার কোর্স</h3>
                        <p class="text-gray-600 text-sm mb-4">বেসিক কম্পিউটার ও প্রোগ্রামিং শেখা</p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-center gap-2 text-sm text-gray-700">
                                <i class="fas fa-check-circle text-green-500"></i>
                                <span>মাইক্রোসফট অফিস</span>
                            </li>
                            <li class="flex items-center gap-2 text-sm text-gray-700">
                                <i class="fas fa-check-circle text-green-500"></i>
                                <span>ইন্টারনেট ব্যবহার</span>
                            </li>
                            <li class="flex items-center gap-2 text-sm text-gray-700">
                                <i class="fas fa-check-circle text-green-500"></i>
                                <span>বেসিক প্রোগ্রামিং</span>
                            </li>
                        </ul>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div>
                                <div class="text-xs text-gray-500">মাসিক ফি</div>
                                <div class="text-lg font-bold text-orange-600">১২০০-১৮০০ টাকা</div>
                            </div>
                            <a href="#admission" class="px-4 py-2 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg font-semibold text-sm hover:shadow-lg transition-all">
                                ভর্তি হন
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">শিক্ষার্থীরা পাচ্ছে</h2>
                    <p class="text-lg text-gray-600">আমাদের কোর্সে যা যা সুবিধা রয়েছে</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-gray-50 p-8 rounded-2xl text-center hover:bg-white hover:shadow-xl transition-all transform hover:-translate-y-2">
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl flex items-center justify-center text-white text-3xl mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">লাইভ ক্লাস</h3>
                        <p class="text-gray-600">সাপ্তাহিক লাইভ ক্লাসে অংশগ্রহণ করুন দেশসেরা শিক্ষকদের সাথে</p>
                    </div>

                    <div class="bg-gray-50 p-8 rounded-2xl text-center hover:bg-white hover:shadow-xl transition-all transform hover:-translate-y-2">
                        <div class="w-20 h-20 bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl flex items-center justify-center text-white text-3xl mx-auto mb-4">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h3 class="text-xl font-bold text gray-900 mb-2">প্রিন্টেড বই</h3>
                        <p class="text-gray-600">প্রিন্টেড মাস্টারবুক ও সাথে এক্সট্রা নোটস সম্পূর্ণ বিনামূল্যে</p>
                    </div>

                    <div class="bg-gray-50 p-8 rounded-2xl text-center hover:bg-white hover:shadow-xl transition-all transform hover:-translate-y-2">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center text-white text-3xl mx-auto mb-4">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">অনলাইন ও অফলাইন</h3>
                        <p class="text-gray-600">ঘরে বসে অনলাইনে অথবা ক্লাসরুমে এসে শিখুন</p>
                    </div>

                    <div class="bg-gray-50 p-8 rounded-2xl text-center hover:bg-white hover:shadow-xl transition-all transform hover:-translate-y-2">
                        <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center text-white text-3xl mx-auto mb-4">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">নিয়মিত পরীক্ষা</h3>
                        <p class="text-gray-600">সাপ্তাহিক পরীক্ষা ও হোমওয়ার্কের মাধ্যমে নিজেকে যাচাই করুন</p>
                    </div>

                    <div class="bg-gray-50 p-8 rounded-2xl text-center hover:bg-white hover:shadow-xl transition-all transform hover:-translate-y-2">
                        <div class="w-20 h-20 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center text-white text-3xl mx-auto mb-4">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">ব্যক্তিগত যত্ন</h3>
                        <p class="text-gray-600">ছোট ব্যাচে প্রতিটি শিক্ষার্থীকে ব্যক্তিগত যত্ন ও সহায়তা</p>
                    </div>

                    <div class="bg-gray-50 p-8 rounded-2xl text-center hover:bg-white hover:shadow-xl transition-all transform hover:-translate-y-2">
                        <div class="w-20 h-20 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center text-white text-3xl mx-auto mb-4">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">সার্টিফিকেট</h3>
                        <p class="text-gray-600">কোর্স সম্পন্ন করে পাবেন সার্টিফিকেট</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <span class="inline-block text-purple-600 font-semibold mb-2">আমাদের সম্পর্কে</span>
                        <h2 class="text-4xl font-bold text-gray-900 mb-6">ব্রাইট একাডেমিক কেয়ার - শিক্ষার মানোন্নয়নে প্রতিশ্রুতিবদ্ধ</h2>
                        <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                            ব্রাইট একাডেমিক কেয়ারের মূল লক্ষ্য হলো প্রতিটি শিক্ষার্থীর সুপ্ত প্রতিভা বিকশিত করা এবং 
                            তাদের একাডেমিক ও ব্যক্তিত্ব উন্নয়নে সহায়তা করা। আমরা বিশ্বাস করি যে প্রতিটি শিশুর মধ্যে 
                            অসীম সম্ভাবনা রয়েছে।
                        </p>
                        <div class="space-y-3 mb-8">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                <span class="text-gray-700 font-medium">অভিজ্ঞ ও দক্ষ শিক্ষকমণ্ডলী</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                <span class="text-gray-700 font-medium">আধুনিক শিক্ষা পদ্ধতি</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                <span class="text-gray-700 font-medium">ছোট ব্যাচে ব্যক্তিগত যত্ন</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                <span class="text-gray-700 font-medium">নিয়মিত মূল্যায়ন ও ফিডব্যাক</span>
                            </div>
                        </div>
                        <a href="#contact" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-xl font-semibold hover:shadow-lg transform hover:scale-105 transition-all">
                            <span>আরও জানুন</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-white p-6 rounded-2xl shadow-lg text-center hover:shadow-xl transition-all transform hover:-translate-y-2">
                            <div class="text-5xl mb-2">🎓</div>
                            <div class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-pink-500 bg-clip-text text-transparent mb-1 counter" data-target="3000" data-suffix="+">০</div>
                            <div class="text-gray-600 font-medium">সফল শিক্ষার্থী</div>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-lg text-center hover:shadow-xl transition-all transform hover:-translate-y-2">
                            <div class="text-5xl mb-2">📚</div>
                            <div class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-pink-500 bg-clip-text text-transparent mb-1 counter" data-target="17" data-suffix="+">০</div>
                            <div class="text-gray-600 font-medium">বছরের অভিজ্ঞতা</div>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-lg text-center hover:shadow-xl transition-all transform hover:-translate-y-2">
                            <div class="text-5xl mb-2">👨‍🏫</div>
                            <div class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-pink-500 bg-clip-text text-transparent mb-1 counter" data-target="45" data-suffix="+">০</div>
                            <div class="text-gray-600 font-medium">অভিজ্ঞ শিক্ষক</div>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-lg text-center hover:shadow-xl transition-all transform hover:-translate-y-2">
                            <div class="text-5xl mb-2">⭐</div>
                            <div class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-pink-500 bg-clip-text text-transparent mb-1 counter" data-target="100" data-suffix="%">০</div>
                            <div class="text-gray-600 font-medium">সফলতার হার</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section id="testimonials" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">কেন আমরাই শিক্ষার্থী ও অভিভাবকদের প্রথম পছন্দ?</h2>
                    <p class="text-lg text-gray-600">আমাদের সফল শিক্ষার্থী ও অভিভাবকদের অভিজ্ঞতা</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-gray-50 p-8 rounded-2xl hover:bg-white hover:shadow-xl transition-all">
                        <div class="flex gap-1 text-yellow-500 mb-4">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="text-gray-700 mb-6 leading-relaxed">
                            "ব্রাইট একাডেমিক কেয়ারে পড়াশোনা করে আমার ছেলের রেজাল্ট অনেক উন্নতি হয়েছে। 
                            শিক্ষকরা খুবই যত্নশীল এবং বিষয়ভিত্তিক দক্ষতা চমৎকার।"
                        </p>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-pink-500 rounded-full flex items-center justify-center text-white text-xl">
                                👨‍👩‍👧
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">রহিমা খাতুন</h4>
                                <p class="text-sm text-gray-600">অভিভাবক - ক্লাস ৮</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-8 rounded-2xl hover:bg-white hover:shadow-xl transition-all">
                        <div class="flex gap-1 text-yellow-500 mb-4">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="text-gray-700 mb-6 leading-relaxed">
                            "এখানকার শিক্ষা পদ্ধতি অনেক আধুনিক। গণিত আর বিজ্ঞানে আমার দুর্বলতা কাটিয়ে উঠতে পেরেছি। 
                            এখন আমি ক্লাসে প্রথম হই।"
                        </p>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-cyan-500 rounded-full flex items-center justify-center text-white text-xl">
                                👨‍🎓
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">সাকিব হাসান</h4>
                                <p class="text-sm text-gray-600">শিক্ষার্থী - ক্লাস ১০</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-8 rounded-2xl hover:bg-white hover:shadow-xl transition-all">
                        <div class="flex gap-1 text-yellow-500 mb-4">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="text-gray-700 mb-6 leading-relaxed">
                            "HSC পরীক্ষায় A+ পেতে পেরেছি ব্রাইট একাডেমিক কেয়ারের কারণেই। 
                            শিক্ষকরা প্রতিটি বিষয়ে গভীর জ্ঞান রাখেন।"
                        </p>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-rose-600 rounded-full flex items-center justify-center text-white text-xl">
                                👩‍🎓
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">ফাতেমা আক্তার</h4>
                                <p class="text-sm text-gray-600">প্রাক্তন শিক্ষার্থী - HSC 2024</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery Section -->
        <section id="gallery" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">আমাদের গ্যালারি</h2>
                    <p class="text-lg text-gray-600">আমাদের প্রতিষ্ঠানের কিছু বিশেষ মুহূর্ত</p>
                </div>

                <!-- Gallery Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Gallery Item 1 -->
                    <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 cursor-pointer">
                        <div class="aspect-w-4 aspect-h-3 bg-gradient-to-br from-purple-200 to-pink-200">
                            <img src="images/nn.jpg" alt="শ্রেণিকক্ষ" class="w-full h-72 object-cover transform group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fas fa-chalkboard-teacher text-2xl"></i>
                                    <h3 class="text-xl font-bold">শ্রেণিকক্ষ</h3>
                                </div>
                                <p class="text-sm text-gray-200">আধুনিক সুবিধা সম্পন্ন শ্রেণিকক্ষে পাঠদান</p>
                            </div>
                        </div>
                    </div>

                    <!-- Gallery Item 2 -->
                    <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 cursor-pointer">
                        <div class="aspect-w-4 aspect-h-3 bg-gradient-to-br from-blue-200 to-cyan-200">
                            <img src="images/ss.jpg" alt="শিক্ষার্থীগণ" class="w-full h-72 object-cover transform group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fas fa-users text-2xl"></i>
                                    <h3 class="text-xl font-bold">শিক্ষার্থীগণ</h3>
                                </div>
                                <p class="text-sm text-gray-200">আমাদের মেধাবী ও উৎসাহী শিক্ষার্থীরা</p>
                            </div>
                        </div>
                    </div>

                    <!-- Gallery Item 3 -->
                    <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 cursor-pointer">
                        <div class="aspect-w-4 aspect-h-3 bg-gradient-to-br from-yellow-200 to-orange-200">
                            <img src="images/sg.jpg" alt="পুরস্কার বিতরণী" class="w-full h-72 object-cover transform group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fas fa-award text-2xl"></i>
                                    <h3 class="text-xl font-bold">পুরস্কার বিতরণী</h3>
                                </div>
                                <p class="text-sm text-gray-200">মেধাবী শিক্ষার্থীদের সম্মাননা প্রদান</p>
                            </div>
                        </div>
                    </div>

                    <!-- Gallery Item 4 -->
                    <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 cursor-pointer">
                        <div class="aspect-w-4 aspect-h-3 bg-gradient-to-br from-green-200 to-emerald-200">
                            <img src="images/csg.jpg" alt="ক্লাস পরিবেশ" class="w-full h-72 object-cover transform group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fas fa-book-reader text-2xl"></i>
                                    <h3 class="text-xl font-bold">ক্লাস পরিবেশ</h3>
                                </div>
                                <p class="text-sm text-gray-200">শিক্ষক ও শিক্ষার্থীদের মধ্যে সুসম্পর্ক</p>
                            </div>
                        </div>
                    </div>

                    <!-- Gallery Item 5 -->
                    <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 cursor-pointer">
                        <div class="aspect-w-4 aspect-h-3 bg-gradient-to-br from-pink-200 to-rose-200">
                            <img src="images/bannar.jpg" alt="সাংস্কৃতিক অনুষ্ঠান" class="w-full h-72 object-cover transform group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fas fa-theater-masks text-2xl"></i>
                                    <h3 class="text-xl font-bold">সাংস্কৃতিক অনুষ্ঠান</h3>
                                </div>
                                <p class="text-sm text-gray-200">বার্ষিক সাংস্কৃতিক কর্মকাণ্ড</p>
                            </div>
                        </div>
                    </div>

                    <!-- Gallery Item 6 -->
                    <div class="group relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 cursor-pointer">
                        <div class="aspect-w-4 aspect-h-3 bg-gradient-to-br from-indigo-200 to-purple-200">
                            <img src="images/nn.jpg" alt="পড়াশোনার পরিবেশ" class="w-full h-72 object-cover transform group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-0 left-0 right-0 p-6 text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fas fa-graduation-cap text-2xl"></i>
                                    <h3 class="text-xl font-bold">পড়াশোনার পরিবেশ</h3>
                                </div>
                                <p class="text-sm text-gray-200">মনোযোগী ও শৃঙ্খলাবদ্ধ শিক্ষা পরিবেশ</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- View More Button -->
                <div class="text-center mt-12">
                    <a href="#contact" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-xl font-semibold text-lg hover:shadow-xl transform hover:scale-105 transition-all">
                        <i class="fas fa-images"></i>
                        <span>আরও ছবি দেখুন</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- Admission Section -->
        <section id="admission" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">অনলাইন ভর্তি আবেদন</h2>
                    <p class="text-lg text-gray-600">ঘরে বসে সহজেই ভর্তির আবেদন করুন</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Benefits -->
                    <div class="space-y-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">বিশেষ সুবিধা</h3>
                        
                        <div class="flex items-start gap-4 bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all">
                            <div class="w-14 h-14 bg-gradient-to-br from-purple-600 to-purple-700 rounded-xl flex items-center justify-center text-white text-2xl flex-shrink-0">
                                <i class="fas fa-gift"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">প্রথম মাসে ২০% ছাড়</h4>
                                <p class="text-sm text-gray-600">নতুন শিক্ষার্থীদের জন্য বিশেষ ছাড়</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-600 to-cyan-500 rounded-xl flex items-center justify-center text-white text-2xl flex-shrink-0">
                                <i class="fas fa-book"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">বিনামূল্যে বই ও নোট</h4>
                                <p class="text-sm text-gray-600">সকল প্রয়োজনীয় বই ও নোট প্রদান</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-all">
                            <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl flex items-center justify-center text-white text-2xl flex-shrink-0">
                                <i class="fas fa-medal"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">মেধাবৃত্তির সুযোগ</h4>
                                <p class="text-sm text-gray-600">মেধাবী শিক্ষার্থীদের জন্য বৃত্তি</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form -->
                    <div class="md:col-span-2 bg-white p-8 rounded-2xl shadow-xl">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">ভর্তির আবেদন ফর্ম</h3>
                        
                        <form id="admissionForm" class="space-y-4">
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">শিক্ষার্থীর নাম *</label>
                                    <input type="text" name="student_name" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-600 focus:outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">শ্রেণি *</label>
                                    <select name="class" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-600 focus:outline-none transition-all">
                                        <option value="">শ্রেণি নির্বাচন করুন</option>
                                        <option value="1">১ম শ্রেণি</option>
                                        <option value="2">২য় শ্রেণি</option>
                                        <option value="3">৩য় শ্রেণি</option>
                                        <option value="4">৪র্থ শ্রেণি</option>
                                        <option value="5">৫ম শ্রেণি</option>
                                        <option value="6">৬ষ্ঠ শ্রেণি</option>
                                        <option value="7">৭ম শ্রেণি</option>
                                        <option value="8">৮ম শ্রেণি</option>
                                        <option value="9">৯ম শ্রেণি</option>
                                        <option value="10">১০ম শ্রেণি</option>
                                        <option value="11">একাদশ শ্রেণি</option>
                                        <option value="12">দ্বাদশ শ্রেণি</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">জন্ম তারিখ *</label>
                                    <input type="date" name="birth_date" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-600 focus:outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">লিঙ্গ *</label>
                                    <select name="gender" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-600 focus:outline-none transition-all">
                                        <option value="">নির্বাচন করুন</option>
                                        <option value="male">ছেলে</option>
                                        <option value="female">মেয়ে</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">পিতার নাম *</label>
                                    <input type="text" name="father_name" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-600 focus:outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">মাতার নাম *</label>
                                    <input type="text" name="mother_name" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-600 focus:outline-none transition-all">
                                </div>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">যোগাযোগ নম্বর *</label>
                                    <input type="tel" name="phone" placeholder="০১৭xxxxxxxx" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-600 focus:outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">ইমেইল</label>
                                    <input type="email" name="email" placeholder="example@email.com" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-600 focus:outline-none transition-all">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">ঠিকানা *</label>
                                <textarea name="address" rows="3" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-600 focus:outline-none transition-all"></textarea>
                            </div>

                            <button type="submit" class="w-full mt-6 px-8 py-4 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-xl font-bold text-lg hover:shadow-xl transform hover:scale-105 transition-all flex items-center justify-center gap-2">
                                <i class="fas fa-paper-plane"></i>
                                <span>আবেদন জমা দিন</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">যোগাযোগ করুন</h2>
                    <p class="text-lg text-gray-600">আমাদের সাথে যোগাযোগ করুন আরও তথ্যের জন্য</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-gray-50 p-8 rounded-2xl text-center hover:bg-white hover:shadow-xl transition-all transform hover:-translate-y-2">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-4">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">ফোন নম্বর</h4>
                        <p class="text-gray-600 text-sm">০১৭১৬৬১১২০৮</p>
                        <p class="text-gray-600 text-sm">০১৭১২৯৬৪৩০৮</p>
                        <p class="text-gray-600 text-sm">০১৭১৮৪২৮৪৫২</p>
                    </div>

                    <div class="bg-gray-50 p-8 rounded-2xl text-center hover:bg-white hover:shadow-xl transition-all transform hover:-translate-y-2">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-cyan-500 rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-4">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">ইমেইল</h4>
                        <p class="text-gray-600 text-sm">info@brightacademiccare.com</p>
                    </div>

                    <div class="bg-gray-50 p-8 rounded-2xl text-center hover:bg-white hover:shadow-xl transition-all transform hover:-translate-y-2">
                        <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-rose-600 rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-4">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">ঠিকানা</h4>
                        <p class="text-gray-600 text-sm">ব্রাইট একাডেমিক কেয়ার<br>ঢাকা, বাংলাদেশ</p>
                    </div>

                    <div class="bg-gray-50 p-8 rounded-2xl text-center hover:bg-white hover:shadow-xl transition-all transform hover:-translate-y-2">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center text-white text-2xl mx-auto mb-4">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">সময়সূচি</h4>
                        <p class="text-gray-600 text-sm">সকাল ৮:০০ - রাত ৮:০০<br>সপ্তাহে ৬ দিন</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="images/LOgo.jpg" alt="লোগো" class="h-12 w-12 rounded-full">
                        <h3 class="text-xl font-bold">ব্রাইট একাডেমিক কেয়ার</h3>
                    </div>
                    <p class="text-gray-400 mb-4 leading-relaxed">মানসম্মত শিক্ষা ও যত্নশীল পরিচর্যায় আপনার সন্তানের উজ্জ্বল ভবিষ্যৎ গড়ুন।</p>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-white/10 hover:bg-purple-600 rounded-full flex items-center justify-center transition-all">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 hover:bg-purple-600 rounded-full flex items-center justify-center transition-all">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 hover:bg-purple-600 rounded-full flex items-center justify-center transition-all">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-white/10 hover:bg-purple-600 rounded-full flex items-center justify-center transition-all">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-4">দ্রুত লিংক</h4>
                    <ul class="space-y-2>
                        <li><a href="#home" class="text-gray-400 hover:text-white transition-all">হোম</a></li>
                        <li><a href="#courses" class="text-gray-400 hover:text-white transition-all">কোর্স সমূহ</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white transition-all">আমাদের সম্পর্কে</a></li>
                        <li><a href="#testimonials" class="text-gray-400 hover:text-white transition-all">মতামত</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-4">কোর্স সমূহ</h4>
                    <ul class="space-y-2">
                        <li><a href="#courses" class="text-gray-400 hover:text-white transition-all">প্রাথমিক শিক্ষা</a></li>
                        <li><a href="#courses" class="text-gray-400 hover:text-white transition-all">মাধ্যমিক শিক্ষা</a></li>
                        <li><a href="#courses" class="text-gray-400 hover:text-white transition-all">উচ্চ মাধ্যমিক</a></li>
                        <li><a href="#courses" class="text-gray-400 hover:text-white transition-all">কম্পিউটার কোর্স</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-4">যোগাযোগ</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-center gap-2">
                            <i class="fas fa-phone text-purple-500"></i>
                            <span>০১৭১৬৬১১২০৮</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-envelope text-purple-500"></i>
                            <span class="text-sm">info@brightacademiccare.com</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-purple-500"></i>
                            <span>ঢাকা, বাংলাদেশ</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-gray-700 text-center text-gray-400">
                <p>&copy; ২০২৫ ব্রাইট একাডেমিক কেয়ার। সকল অধিকার সংরক্ষিত।</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop" class="fixed bottom-8 right-8 w-14 h-14 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-full shadow-2xl hover:shadow-purple-500/50 transform hover:scale-110 transition-all opacity-0 invisible z-50">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Back to Top Button
        const backToTop = document.getElementById('backToTop');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTop.classList.remove('opacity-0', 'invisible');
                backToTop.classList.add('opacity-100', 'visible');
            } else {
                backToTop.classList.remove('opacity-100', 'visible');
                backToTop.classList.add('opacity-0', 'invisible');
            }
        });
        
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Form Submission
        const admissionForm = document.getElementById('admissionForm');
        
        admissionForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('আপনার আবেদন সফলভাবে জমা হয়েছে! আমরা শীঘ্রই আপনার সাথে যোগাযোগ করব।');
            admissionForm.reset();
        });

        // Smooth Scroll for Links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    // Close mobile menu if open
                    mobileMenu.classList.add('hidden');
                }
            });
        });

        // Counter Animation with Bengali Numbers
        const bengaliDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        
        function toBengali(num) {
            return String(num).split('').map(digit => {
                return digit === ',' ? ',' : bengaliDigits[parseInt(digit)] || digit;
            }).join('');
        }

        function formatNumber(num) {
            if (num >= 1000) {
                return num.toLocaleString('en-IN');
            }
            return num.toString();
        }

        function animateValue(element, start, end, duration, suffix) {
            const range = end - start;
            const startTime = performance.now();
            
            function update(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                const currentValue = Math.floor(start + (range * progress));
                const formattedValue = formatNumber(currentValue);
                const bengaliValue = toBengali(formattedValue);
                
                element.textContent = bengaliValue + suffix;
                
                if (progress < 1) {
                    requestAnimationFrame(update);
                }
            }
            
            requestAnimationFrame(update);
        }

        // Setup Intersection Observer
        const counters = document.querySelectorAll('.counter');
        let hasAnimated = false;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                    const target = parseInt(entry.target.getAttribute('data-target'));
                    const suffix = entry.target.getAttribute('data-suffix') || '';
                    
                    entry.target.classList.add('animated');
                    animateValue(entry.target, 0, target, 2000, suffix);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px'
        });

        counters.forEach(counter => observer.observe(counter));
        }); // End DOMContentLoaded
    </script>
</body>
</html>
