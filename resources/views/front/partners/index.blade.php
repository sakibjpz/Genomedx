@extends('front.layouts.inner')

@section('title', 'Our Partners - GenomeDX')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-br from-slate-50 to-blue-50 border-b border-gray-100">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-medium mb-6">
                <i class="fas fa-users mr-2"></i>
                Strategic Partnerships
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                Our Global Partners
            </h1>
            <p class="text-lg md:text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">
                We collaborate with industry-leading organizations worldwide to deliver innovative diagnostic solutions and advance healthcare excellence.
            </p>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-20">
    <!-- Partners List -->
    <div class="max-w-7xl mx-auto space-y-8 lg:space-y-12 mb-16 lg:mb-24">
        @forelse($companies as $company)
            <article class="group">
                <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden hover:shadow-2xl hover:border-blue-200 transition-all duration-500">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                        
                        <!-- Left: Company Logo/Image -->
                        <div class="relative bg-gradient-to-br from-gray-50 to-slate-50 p-8 lg:p-12 flex items-center justify-center min-h-[320px] lg:min-h-[400px]">
                           @if($company->image)
    <img src="{{ asset('storage/' . $company->image) }}" 
         alt="{{ $company->name }}" 
         class="max-w-full max-h-64 object-contain filter grayscale group-hover:grayscale-0 transition duration-500 rounded-lg">
@else
                                <div class="text-center">
                                    <div class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-full shadow-lg mb-6">
                                        <i class="fas fa-building text-blue-600 text-3xl"></i>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-800">{{ $company->name }}</h3>
                                </div>
                            @endif
                            
                            <!-- Corner Accent -->
                            <div class="absolute top-0 right-0 w-32 h-32 bg-blue-600 opacity-5 rounded-bl-full"></div>
                        </div>
                        
                        <!-- Right: Company Information -->
                        <div class="p-8 lg:p-12 flex flex-col justify-center">
                            <!-- Partner Badge -->
                            <div class="mb-6">
                                <span class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-semibold rounded-md uppercase tracking-wide">
                                    <i class="fas fa-award mr-2"></i> Strategic Partner
                                </span>
                            </div>
                            
                            <!-- Company Name -->
                            <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4">
                                {{ $company->name }}
                            </h2>
                            
                            <!-- Description -->
                            <div class="text-gray-600 mb-8 space-y-4">
                                <p class="text-base leading-relaxed">
                                    @if($company->description)
                                        {{ $company->description }}
                                    @else
                                        {{ $company->name }} is a valued partner in our mission to advance diagnostic solutions. Together, we collaborate on innovative technologies that improve healthcare outcomes and expand access to quality diagnostics globally.
                                    @endif
                                </p>
                            </div>
                            
                            <!-- Key Features Grid -->
                            <div class="grid grid-cols-2 gap-4 mb-8 pb-8 border-b border-gray-100">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-certificate text-blue-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Quality</p>
                                        <p class="text-sm font-semibold text-gray-900">ISO Certified</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-globe-americas text-green-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Reach</p>
                                        <p class="text-sm font-semibold text-gray-900">Global Network</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-lightbulb text-purple-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Innovation</p>
                                        <p class="text-sm font-semibold text-gray-900">R&D Focused</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 w-10 h-10 bg-orange-50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-handshake text-orange-600 text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Trust</p>
                                        <p class="text-sm font-semibold text-gray-900">Proven Track Record</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Button -->
                            <div>
                                <a href="{{ route('companies.show', $company) }}" 
                                   class="inline-flex items-center text-blue-600 hover:text-blue-700 font-semibold group/link transition">
                                    <span>Learn More About This Partnership</span>
                                    <i class="fas fa-arrow-right ml-2 transform group-hover/link:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <!-- Empty State -->
            <div class="text-center py-20 lg:py-32">
                <div class="max-w-md mx-auto">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-6">
                        <i class="fas fa-handshake text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">No Partners Listed</h3>
                    <p class="text-gray-600 mb-8">
                        We're building strategic partnerships to expand our global reach. Check back soon for updates.
                    </p>
                    <a href="{{ url('/contact') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-envelope mr-2"></i> Partner With Us
                    </a>
                </div>
            </div>
        @endforelse
    </div>
    
    <!-- Partnership CTA Section -->
    <div class="max-w-7xl mx-auto mb-16 lg:mb-24">
        <div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 rounded-3xl overflow-hidden shadow-xl">
            <!-- Background Decoration -->
            <div class="absolute inset-0 bg-grid-white/[0.05] bg-[size:20px_20px]"></div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-900/30 rounded-full blur-3xl"></div>
            
            <div class="relative px-6 py-12 lg:py-16 lg:px-12">
                <div class="max-w-3xl mx-auto text-center">
                    <!-- Badge -->
                    <div class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-medium mb-6">
                        <i class="fas fa-rocket mr-2"></i>
                        Partnership Opportunities
                    </div>
                    
                    <!-- Heading -->
                    <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4 lg:mb-6">
                        Interested in Becoming a Partner?
                    </h2>
                    
                    <!-- Description -->
                    <p class="text-base lg:text-lg text-blue-50 mb-8 lg:mb-10 leading-relaxed">
                        Join our network of industry leaders committed to advancing diagnostic innovation. 
                        Let's explore how we can create value together.
                    </p>
                    
                    <!-- CTA Button -->
                    <div class="flex justify-center">
                        <a href="{{ url('/contact') }}" 
                           class="inline-flex items-center justify-center px-10 py-4 bg-white text-blue-700 font-semibold rounded-xl hover:bg-blue-50 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                            <i class="fas fa-handshake mr-2"></i> 
                            Contact Us for Partnership
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Trust Indicators -->
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-10 lg:mb-12">
            <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3 lg:mb-4">Why Partner With Us</h3>
            <p class="text-gray-600 max-w-2xl mx-auto text-base lg:text-lg">
                Our partnerships are built on trust, innovation, and a shared commitment to excellence.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            <div class="bg-white border border-gray-100 rounded-2xl p-8 text-center hover:shadow-lg hover:border-blue-100 transition-all duration-300">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 rounded-2xl mb-5">
                    <i class="fas fa-trophy text-blue-600 text-2xl"></i>
                </div>
                <h4 class="text-lg lg:text-xl font-bold text-gray-900 mb-3">Industry Excellence</h4>
                <p class="text-gray-600 text-sm lg:text-base leading-relaxed">
                    Recognized leader in diagnostic solutions with proven track record of success.
                </p>
            </div>
            
            <div class="bg-white border border-gray-100 rounded-2xl p-8 text-center hover:shadow-lg hover:border-green-100 transition-all duration-300">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-50 rounded-2xl mb-5">
                    <i class="fas fa-chart-line text-green-600 text-2xl"></i>
                </div>
                <h4 class="text-lg lg:text-xl font-bold text-gray-900 mb-3">Growth Focused</h4>
                <p class="text-gray-600 text-sm lg:text-base leading-relaxed">
                    Committed to mutual growth through collaborative innovation and market expansion.
                </p>
            </div>
            
            <div class="bg-white border border-gray-100 rounded-2xl p-8 text-center hover:shadow-lg hover:border-purple-100 transition-all duration-300">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-50 rounded-2xl mb-5">
                    <i class="fas fa-shield-alt text-purple-600 text-2xl"></i>
                </div>
                <h4 class="text-lg lg:text-xl font-bold text-gray-900 mb-3">Quality Assurance</h4>
                <p class="text-gray-600 text-sm lg:text-base leading-relaxed">
                    Maintaining highest standards in all partnerships with rigorous quality controls.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection