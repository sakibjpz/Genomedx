@extends('front.layouts.inner')

@section('title', 'About Us - GenomeDX Corporation')

@section('content')

<!-- Hero Section -->
<section class="relative text-white py-20 md:py-32 overflow-hidden" 
         style="background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 50%, #2563eb 100%);">
    
    <!-- Dark overlay for better text contrast -->
    <div class="absolute inset-0" style="background: rgba(0, 0, 0, 0.3);"></div>
    
    <!-- Decorative elements with better opacity -->
    <div class="absolute top-0 right-0 w-64 h-64 rounded-full" 
         style="background: radial-gradient(circle, #3b82f6 0%, transparent 70%); 
                transform: translate(-30%, -30%);
                opacity: 0.4;"></div>
    
    <div class="absolute bottom-0 left-0 w-96 h-96 rounded-full" 
         style="background: radial-gradient(circle, #60a5fa 0%, transparent 70%);
                transform: translate(30%, 30%);
                opacity: 0.3;"></div>
    
    <!-- Add a subtle pattern overlay -->
    <div class="absolute inset-0" 
         style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cdefs%3E%3Cpattern id=\"smallGrid\" width=\"60\" height=\"60\" patternUnits=\"userSpaceOnUse\"%3E%3Cpath d=\"M 60 0 L 0 0 0 60\" fill=\"none\" stroke=\"rgba(255,255,255,0.05)\" stroke-width=\"1\" /%3E%3C/pattern%3E%3C/defs%3E%3Crect width=\"100%25\" height=\"100%25\" fill=\"url(%23smallGrid)\" /%3E%3C/svg%3E');
                opacity: 0.5;"></div>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight" 
                style="text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);">
                Pioneering Genomic 
                <span style="background: linear-gradient(90deg, #93c5fd 0%, #bfdbfe 100%); 
                            -webkit-background-clip: text; 
                            -webkit-text-fill-color: transparent; 
                            background-clip: text;">
                    Innovation
                </span>
            </h1>
            
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto" 
               style="color: #dbeafe; text-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);">
                Leading the future of molecular diagnostics with cutting-edge PCR technology and unwavering commitment to healthcare excellence.
            </p>
            
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#our-story" 
                   class="px-8 py-3 font-bold rounded-lg transition-all duration-300 transform hover:-translate-y-1"
                   style="background: white; 
                          color: #1e3a8a; 
                          box-shadow: 0 4px 20px rgba(255, 255, 255, 0.2);
                          border: 2px solid white;">
                    Our Story
                </a>
                
                <a href="#contact" 
                   class="px-8 py-3 font-bold rounded-lg transition-all duration-300 transform hover:-translate-y-1"
                   style="background: transparent; 
                          color: white; 
                          border: 2px solid white;
                          box-shadow: 0 4px 20px rgba(255, 255, 255, 0.1);">
                    Get In Touch
                </a>
            </div>
        </div>
    </div>
</section>
<!-- Quick Stats -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="p-6">
                <div class="text-4xl md:text-5xl font-bold text-blue-700 mb-2">15+</div>
                <div class="text-gray-600 font-medium">Years Experience</div>
            </div>
            <div class="p-6">
                <div class="text-4xl md:text-5xl font-bold text-blue-700 mb-2">500+</div>
                <div class="text-gray-600 font-medium">Products</div>
            </div>
            <div class="p-6">
                <div class="text-4xl md:text-5xl font-bold text-blue-700 mb-2">40+</div>
                <div class="text-gray-600 font-medium">Countries Served</div>
            </div>
            <div class="p-6">
                <div class="text-4xl md:text-5xl font-bold text-blue-700 mb-2">50K+</div>
                <div class="text-gray-600 font-medium">Tests Daily</div>
            </div>
        </div>
    </div>
</section>

<!-- Our Story -->
<section id="our-story" class="py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Our Story</h2>
                <div class="w-24 h-1 bg-blue-600 mx-auto"></div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">From Vision to Global Impact</h3>
                    <div class="prose prose-lg max-w-none">
                        <p class="text-gray-700 mb-4">
                            Founded in 2008, <strong>GenomeDX Corporation</strong> began with a simple yet powerful vision: to revolutionize molecular diagnostics through innovative PCR technology. What started as a small research laboratory in Dhaka has grown into a globally recognized leader in genomic solutions.
                        </p>
                        <p class="text-gray-700 mb-4">
                            Our journey has been marked by relentless innovation, strategic partnerships, and an unwavering commitment to improving patient outcomes worldwide. Today, our products are trusted by leading laboratories, research institutions, and healthcare providers across 40+ countries.
                        </p>
                        <p class="text-gray-700">
                            We continue to push the boundaries of what's possible in molecular diagnostics, developing cutting-edge solutions for infectious diseases, genetic disorders, and personalized medicine.
                        </p>
                    </div>
                </div>
                <div class="relative">
                    <div class="bg-gradient-to-br from-blue-100 to-white p-8 rounded-2xl shadow-xl">
                        <img src="https://images.unsplash.com/photo-1559757148-5c350d0d3c56?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
                             alt="Modern Laboratory"
                             class="w-full h-64 md:h-80 object-cover rounded-lg shadow-lg">
                    </div>
                    <div class="absolute -bottom-6 -right-6 w-48 h-48 bg-blue-600 rounded-2xl -z-10 opacity-10"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-20 bg-gradient-to-b from-white to-blue-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Our Core Values</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Guiding principles that drive our innovation and growth</p>
                <div class="w-24 h-1 bg-blue-600 mx-auto mt-4"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Mission -->
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-bullseye text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Our Mission</h3>
                    <p class="text-gray-700">
                        To advance global healthcare through innovative, reliable, and accessible molecular diagnostics that empower clinicians, researchers, and patients with accurate, timely information.
                    </p>
                </div>
                
                <!-- Vision -->
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-gradient-to-r from-green-600 to-green-700 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-eye text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Our Vision</h3>
                    <p class="text-gray-700">
                        To be the world's most trusted partner in genomic diagnostics, setting new standards for accuracy, innovation, and impact in personalized medicine and public health.
                    </p>
                </div>
                
                <!-- Values -->
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-600 to-purple-700 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-heart text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Our Values</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Scientific Excellence</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Integrity & Ethics</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Innovation & Quality</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Customer Focus</li>
                        <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i> Global Responsibility</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Strategy -->
<section class="py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Our Strategic Approach</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Driving innovation through focused strategy</p>
                <div class="w-24 h-1 bg-blue-600 mx-auto mt-4"></div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div class="space-y-8">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                <span class="text-blue-700 font-bold text-lg">1</span>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2">Research & Development</h4>
                            <p class="text-gray-700">Continuous investment in cutting-edge PCR technology and novel diagnostic solutions.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                <span class="text-green-700 font-bold text-lg">2</span>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2">Global Expansion</h4>
                            <p class="text-gray-700">Strategic partnerships and regulatory approvals to serve diverse healthcare markets worldwide.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                                <span class="text-purple-700 font-bold text-lg">3</span>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2">Quality & Compliance</h4>
                            <p class="text-gray-700">Adherence to international standards (ISO, CE-IVD, FDA) ensuring product reliability.</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-blue-50 to-white p-8 rounded-2xl shadow-lg">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Future Roadmap</h3>
                    <div class="space-y-6">
                        <div class="border-l-4 border-blue-600 pl-4">
                            <h4 class="font-bold text-gray-900">2025-2026</h4>
                            <p class="text-gray-700">Launch of next-generation multiplex PCR platforms</p>
                        </div>
                        <div class="border-l-4 border-green-600 pl-4">
                            <h4 class="font-bold text-gray-900">2026-2027</h4>
                            <p class="text-gray-700">Expansion into personalized cancer diagnostics</p>
                        </div>
                        <div class="border-l-4 border-purple-600 pl-4">
                            <h4 class="font-bold text-gray-900">2027-2028</h4>
                            <p class="text-gray-700">AI-powered diagnostic decision support systems</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="py-20 bg-gray-900 text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Our World</h2>
                <p class="text-gray-300 max-w-2xl mx-auto">State-of-the-art facilities and dedicated teams</p>
                <div class="w-24 h-1 bg-blue-500 mx-auto mt-4"></div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="relative overflow-hidden rounded-xl group">
                    <img src="https://images.unsplash.com/photo-1559757175-0eb30cd8c063?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                         alt="Research Laboratory"
                         class="w-full h-64 object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6">
                        <h4 class="text-white font-bold">Research Lab</h4>
                    </div>
                </div>
                
                <div class="relative overflow-hidden rounded-xl group">
                    <img src="https://images.unsplash.com/photo-1582719508461-905c673771fd?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                         alt="Production Facility"
                         class="w-full h-64 object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6">
                        <h4 class="text-white font-bold">Production</h4>
                    </div>
                </div>
                
                <div class="relative overflow-hidden rounded-xl group">
                    <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                         alt="Quality Control"
                         class="w-full h-64 object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6">
                        <h4 class="text-white font-bold">Quality Control</h4>
                    </div>
                </div>
                
                <div class="relative overflow-hidden rounded-xl group">
                    <img src="https://images.unsplash.com/photo-1551601651-2a8555f1a136?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" 
                         alt="Team Collaboration"
                         class="w-full h-64 object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-6">
                        <h4 class="text-white font-bold">Our Team</h4>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <p class="text-gray-300 mb-6">We're proud of our world-class facilities and dedicated team</p>
                <a href="#contact" 
                   class="inline-flex items-center px-8 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-camera mr-2"></i>
                    View More Photos
                </a>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section id="contact" class="py-20 bg-gradient-to-r from-blue-700 to-blue-900 text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Partner With Us</h2>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Join us in shaping the future of molecular diagnostics. Let's innovate together for better healthcare outcomes.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}" 
                   class="px-8 py-4 bg-white text-blue-900 font-bold rounded-lg hover:bg-blue-50 transition flex items-center justify-center">
                    <i class="fas fa-handshake mr-2"></i>
                    Become a Partner
                </a>
                <a href="{{ route('contact') }}" 
                   class="px-8 py-4 border-2 border-white text-white font-bold rounded-lg hover:bg-white/10 transition flex items-center justify-center">
                    <i class="fas fa-envelope mr-2"></i>
                    Contact Our Team
                </a>
            </div>
        </div>
    </div>
</section>

@endsection