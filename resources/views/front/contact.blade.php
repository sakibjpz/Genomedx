@extends('front.layouts.inner')

@section('content')
<section class="py-0 bg-white">
    <!-- Hero/Banner Section - Updated Professional Design -->
    <div class="banner-professional text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-7xl mx-auto">
                <nav class="breadcrumb-wrapper">
                    <ol class="flex items-center">
                        <li>
                            <a href="{{ url('/') }}" class="breadcrumb-item text-blue-100 hover:text-white transition">
                                Home
                            </a>
                        </li>
                        <li class="breadcrumb-separator">/</li>
                        <li class="breadcrumb-item text-white font-medium">Contact</li>
                    </ol>
                </nav>
                
                {{-- <h1 class="text-display mb-2">Contact</h1> --}}
                
                <p class="text-display mb-2">
                    Write us, we will answer you as soon as possible.
                </p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8 section-spacing">
        <div class="max-w-7xl mx-auto">
            
            <!-- Introduction Text -->
            <div class="mb-8">
                <h2 class="text-2xl md:text-3xl text-gray-800 mb-4 font-normal text-body">
                    Write us, we will answer you as soon as possible.
                </h2>
                <p class="text-base text-gray-700 font-semibold text-body">
                    Remember to check your Spam folder, it is likely that the emails we sent you are there. 
                    Open them and mark the content as safe or remove the Spam label.
                </p>
            </div>

            <!-- Advice Note -->
            <div class="alert-note mb-8">
                <h3 class="alert-title">ADVICE NOTE</h3>
                <div class="alert-content space-y-3">
                    <p>
                        Before contacting us, please <strong>be advised that our tests are not intended for sale to the general public</strong>, 
                        so we cannot guarantee a response to queries outside the channels for which they are designed.
                    </p>
                    <p>
                        Also, please consider that <strong>the use of all GenomeDX tests must be carried out according to the purpose for which 
                        they are validated</strong>, in accordance with the regulations applicable in each country, by the appropriate 
                        personnel for it and in the place / facilities allowed.
                    </p>
                </div>
            </div>

            <hr class="divider">

            <!-- Two Column Layout: 70% Left, 30% Right -->
            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- Left Column - Contact Form (70%) -->
                <div class="w-full lg:w-[70%]">
                    <div class="form-card animate-fadeIn">
                        <!-- Success/Error Messages -->
                        @if(session('success'))
                            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if($errors->any())
                            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                                <ul class="list-disc list-inside text-sm">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Hidden Company Field (Honeypot) -->
                            <div class="mb-4 hidden">
                                <label for="company_optional" class="form-label">Company</label>
                                <input type="text" id="company_optional" name="company_optional"
                                       class="form-control">
                                <p class="form-hint">This field is for validation purposes and should be left unchanged.</p>
                            </div>

                            <!-- Form Section: Area Selection -->
                            <div class="form-section">
                                <h4 class="form-section-title">Contact Information</h4>
                                
                                <!-- Area Selection -->
                                <div class="mb-8">
                                    <label class="form-label">
                                        Area <span class="required-star">*</span>
                                    </label>
                                    <div class="radio-group">
                                        @foreach($queryTypes as $queryType)
                                        <div class="radio-option {{ old('query_type') == $queryType->name ? 'selected' : '' }} {{ $loop->first && !old('query_type') ? 'selected' : '' }}">
                                            <div class="flex items-start">
                                                <input type="radio" id="type_{{ $queryType->id }}" 
                                                       name="query_type" 
                                                       value="{{ $queryType->name }}" 
                                                       class="radio-option-input" 
                                                       {{ old('query_type') == $queryType->name ? 'checked' : '' }}
                                                       {{ $loop->first && !old('query_type') ? 'checked' : '' }}>
                                                <div class="flex-1">
                                                    <label for="type_{{ $queryType->id }}" class="radio-option-label">
                                                        {{ $queryType->display_name }}
                                                    </label>
                                                    @if($queryType->description)
                                                        <p class="radio-option-desc">{{ $queryType->description }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @error('query_type')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Form Grid for Name, Email, Phone -->
                                <div class="form-grid form-grid-2 mb-8">
                                    <!-- Full Name -->
                                    <div>
                                        <label for="name" class="form-label">
                                            Full name <span class="required-star">*</span>
                                        </label>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                               class="form-control">
                                        @error('name')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label for="email" class="form-label">
                                            Email <span class="required-star">*</span>
                                        </label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                               class="form-control">
                                        @error('email')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div>
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                               class="form-control">
                                    </div>

                                    <!-- Company -->
                                    <div>
                                        <label for="company" class="form-label">
                                            Company <span class="required-star">*</span>
                                        </label>
                                        <input type="text" id="company" name="company" value="{{ old('company') }}" required
                                               class="form-control">
                                        @error('company')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Profile and Country -->
                                <div class="form-grid form-grid-2 mb-8">
                                    <!-- Profile -->
                                    <div>
                                        <label for="profile" class="form-label">
                                            Profile <span class="required-star">*</span>
                                        </label>
                                        <select id="profile" name="profile" required
                                                class="form-control">
                                            <option value="">-</option>
                                            <option value="Distributor" {{ old('profile') == 'Distributor' ? 'selected' : '' }}>Distributor</option>
                                            <option value="Doctor" {{ old('profile') == 'Doctor' ? 'selected' : '' }}>Doctor</option>
                                            <option value="Hospital" {{ old('profile') == 'Hospital' ? 'selected' : '' }}>Hospital</option>
                                            <option value="Diagnostic Center" {{ old('profile') == 'Diagnostic Center' ? 'selected' : '' }}>Diagnostic Center</option>
                                            <option value="Student" {{ old('profile') == 'Student' ? 'selected' : '' }}>Student</option>
                                            <option value="Others" {{ old('profile') == 'Others' ? 'selected' : '' }}>Others</option>
                                        </select>
                                        @error('profile')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Country -->
                                    <div>
                                        <label for="country" class="form-label">
                                            Country <span class="required-star">*</span>
                                        </label>
                                        <select id="country" name="country" required
                                                class="form-control">
                                            <option value="">-</option>
                                            <option value="Bangladesh" {{ old('country') == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                                            <option value="India" {{ old('country') == 'India' ? 'selected' : '' }}>India</option>
                                            <option value="Pakistan" {{ old('country') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                                            <option value="Afghanistan" {{ old('country') == 'Afghanistan' ? 'selected' : '' }}>Afghanistan</option>
                                            <option value="United States" {{ old('country') == 'United States' ? 'selected' : '' }}>United States</option>
                                            <option value="United Kingdom" {{ old('country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                            <option value="China" {{ old('country') == 'China' ? 'selected' : '' }}>China</option>
                                            <option value="Japan" {{ old('country') == 'Japan' ? 'selected' : '' }}>Japan</option>
                                            <option value="Germany" {{ old('country') == 'Germany' ? 'selected' : '' }}>Germany</option>
                                            <option value="France" {{ old('country') == 'France' ? 'selected' : '' }}>France</option>
                                            <option value="Spain" {{ old('country') == 'Spain' ? 'selected' : '' }}>Spain</option>
                                            <option value="Italy" {{ old('country') == 'Italy' ? 'selected' : '' }}>Italy</option>
                                            <option value="Canada" {{ old('country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                                            <option value="Australia" {{ old('country') == 'Australia' ? 'selected' : '' }}>Australia</option>
                                            <option value="Brazil" {{ old('country') == 'Brazil' ? 'selected' : '' }}>Brazil</option>
                                        </select>
                                        @error('country')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Message -->
                                <div class="mb-8">
                                    <label for="message" class="form-label">
                                        Message <span class="required-star">*</span>
                                    </label>
                                    <textarea id="message" name="message" rows="5" required
                                              class="form-control">{{ old('message') }}</textarea>
                                    @error('message')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- File Upload -->
<div class="mb-8">
    <label for="attachment" class="form-label">
        Attach File (Optional)
    </label>
    <input type="file" id="attachment" name="attachment" 
           class="form-control-file"
           accept=".rex,.lc96u,.txt,.csv,.xls,.xlsx,.pdf,.doc,.docx">
    <p class="form-hint mt-2">
        Supported file types: PCR machine files (.rex, .lc96u), documents, spreadsheets, etc.
        <br>Max file size: 10MB
    </p>
    @error('attachment')
        <p class="error-message">{{ $message }}</p>
    @enderror
</div>
                            </div>

                            <!-- Privacy Policy Box -->
                            <div class="privacy-box mb-8">
                                <p class="text-sm text-gray-700 mb-4 leading-relaxed">
                                    As a legally responsible entity, GenomeDX Corporation processes your personal data to respond 
                                    to your queries and requests. You can visit our website 
                                    <a href="#" class="contact-link">Privacy Policy</a> to know more 
                                    about all the legal information on Data Protection, including how to exercise your rights 
                                    of access, rectification, deletion, opposition, and others recognized by current legislation.
                                </p>
                                
                                <div class="checkbox-wrapper">
                                    <input type="checkbox" name="privacy_policy" required
                                           class="checkbox-input">
                                    <label class="checkbox-label">
                                        I have read the <a href="#" class="contact-link">Privacy Policy</a> document 
                                        and I agree the <a href="#" class="contact-link">Conditions of Use</a>.
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-start">
                                <button type="submit"
                                        class="btn-primary">
                                    SEND MESSAGE
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Column - Company Information (30%) -->
                <div class="w-full lg:w-[30%]">
                    <div class="contact-card sticky top-6">
                        <h3 class="contact-card-title">GenomeDX Corporation</h3>
                        
                        <div class="space-y-5">
                            <!-- Address -->
                            <div class="contact-item">
                                <i class="fas fa-map-marker-alt contact-icon"></i>
                                <div>
                                    <p class="contact-text">
                                        205/1 (1st Floor), Dr.Kudrat-E-Khuda Road<br>
                                        50840, Dhaka-1205<br>
                                        Bangladesh
                                    </p>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="contact-item">
                                <i class="fas fa-phone contact-icon"></i>
                                <div>
                                    <p class="contact-text">
                                        <a href="tel:+88029664349" class="contact-link">
                                            +880 2966 4349
                                        </a>
                                    </p>
                                </div>
                            </div>

                            <!-- GPS -->
                            <div class="contact-item">
                                <i class="fas fa-location-dot contact-icon"></i>
                                <div>
                                    <p class="contact-text">GPS: 41.82183, -0.77329</p>
                                </div>
                            </div>

                            <!-- Divider -->
                            <hr class="border-gray-300 my-4">

                            <!-- Email -->
                            <div class="contact-item">
                                <i class="fas fa-envelope contact-icon"></i>
                                <div>
                                    <a href="mailto:genomedxcorporation@gmail.com" 
                                       class="contact-link break-all">
                                        genomedxcorporation@gmail.com
                                    </a>
                                </div>
                            </div>

                            <!-- Website -->
                            <div class="contact-item">
                                <i class="fas fa-globe contact-icon"></i>
                                <div>
                                    <a href="https://www.genomedxbd.com" target="_blank"
                                       class="contact-link break-all">
                                        www.genomedxbd.com
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Export Team Section -->
@php
    $teamMembers = \App\Models\TeamMember::active()->get();
@endphp

@if($teamMembers->count() > 0)
<div class="container mx-auto px-4 py-16">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 text-center mb-12">
            Our Export Team
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($teamMembers as $member)
                <div class="bg-gray-50 rounded-lg shadow-md p-6 text-center hover:shadow-lg transition-shadow">
                    <div class="w-32 h-32 mx-auto mb-4 rounded-full overflow-hidden border-4 border-blue-100">
                        @if($member->image)
                            <img src="{{ asset('storage/' . $member->image) }}" 
                                 alt="{{ $member->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-user text-gray-400 text-4xl"></i>
                            </div>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $member->name }}</h3>
                    <p class="text-blue-600 font-medium mb-3">{{ $member->position }}</p>
                    <div class="text-sm text-gray-600 mb-4">
                        <p class="font-medium">{{ $member->regions }}</p>
                    </div>
                    <div class="space-y-2">
                        <p class="text-gray-700 text-sm">
                            <i class="fas fa-envelope mr-2 text-blue-500"></i>
                            {{ $member->email }}
                        </p>
                        <p class="text-gray-700 text-sm">
                            <i class="fas fa-phone mr-2 text-blue-500"></i>
                            {{ $member->phone }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif




</section>

<!-- FontAwesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Add Inter font for better typography -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<script>
    // JavaScript for better radio button interaction
    document.addEventListener('DOMContentLoaded', function() {
        // Add click functionality to radio option cards
        const radioOptions = document.querySelectorAll('.radio-option');
        
        radioOptions.forEach(option => {
            option.addEventListener('click', function(e) {
                // Don't trigger if clicking on the radio input itself
                if (e.target.type === 'radio') return;
                
                const radioInput = this.querySelector('input[type="radio"]');
                if (radioInput) {
                    radioInput.checked = true;
                    
                    // Update visual selection
                    radioOptions.forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');
                }
            });
        });
        
        // Enhance form validation styling
        const form = document.querySelector('form');
        if (form) {
            const inputs = form.querySelectorAll('input, select, textarea');
            
            inputs.forEach(input => {
                // Add error class on invalid
                input.addEventListener('invalid', function(e) {
                    e.preventDefault();
                    this.classList.add('border-red-300');
                });
                
                // Remove error class on input
                input.addEventListener('input', function() {
                    this.classList.remove('border-red-300');
                });
            });
        }
    });
</script>

@endsection

<style>
    /* ====== Enhanced Base Styles ====== */
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        line-height: 1.5;
    }

    /* ====== Typography & Spacing ====== */
    .text-display {
        font-size: 2.5rem;
        line-height: 1.2;
        font-weight: 700;
        letter-spacing: -0.025em;
    }

    @media (max-width: 768px) {
        .text-display {
            font-size: 2rem;
        }
    }

    .text-lead {
        font-size: 1.125rem;
        font-weight: 500;
        color: #374151;
    }

    .text-subtitle {
        font-size: 0.9375rem;
        font-weight: 600;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .text-body {
        color: #4B5563;
        line-height: 1.6;
    }

    .text-caption {
        font-size: 0.8125rem;
        color: #6B7280;
    }

    /* ====== Layout Spacing ====== */
    .section-spacing {
        padding-top: 3rem;
        padding-bottom: 3rem;
    }

    @media (max-width: 768px) {
        .section-spacing {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
    }

    /* ====== Professional Banner ====== */
    .banner-professional {
        background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
        padding-top: 2.5rem;
        padding-bottom: 2.5rem;
        position: relative;
        overflow: hidden;
    }

    .banner-professional::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #60a5fa 0%, #3b82f6 100%);
    }
    /* Add to your existing stylesheet */
.banner-professional h1 {
    font-weight: 800;
    letter-spacing: -0.025em;
    line-height: 1.1;
}

.banner-professional p {
    letter-spacing: -0.01em;
    line-height: 1.6;
}

/* For better text rendering on all devices */
* {
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-rendering: optimizeLegibility;
}

    .breadcrumb-wrapper {
        margin-bottom: 1rem;
    }

    .breadcrumb-item {
        font-size: 0.875rem;
        transition: color 0.2s;
    }

    .breadcrumb-separator {
        color: #93c5fd;
        margin: 0 0.5rem;
    }

    /* ====== Form Card & Layout ====== */
    .form-card {
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
        padding: 2.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    @media (max-width: 768px) {
        .form-card {
            padding: 1.5rem;
        }
    }

    .form-section {
        margin-bottom: 2.5rem;
    }

    .form-section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #f3f4f6;
    }

    /* ====== Enhanced Form Controls ====== */
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .form-control {
        width: 100%;
        border: 1.5px solid #d1d5db;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        font-size: 0.9375rem;
        transition: all 0.2s;
        background-color: #ffffff;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-control::placeholder {
        color: #9ca3af;
    }

    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1.25em 1.25em;
        padding-right: 2.75rem;
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    /* ====== Professional Radio Buttons ====== */
    .radio-group {
        display: grid;
        gap: 0.75rem;
    }

    .radio-option {
        border: 1.5px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 1.25rem;
        transition: all 0.2s;
        cursor: pointer;
        background: #ffffff;
    }

    .radio-option:hover {
        border-color: #3b82f6;
        background-color: #f8fafc;
    }

    .radio-option.selected {
        border-color: #3b82f6;
        background-color: #eff6ff;
        box-shadow: 0 0 0 1px #3b82f6;
    }

    .radio-option-input {
        appearance: none;
        -webkit-appearance: none;
        width: 1.125rem;
        height: 1.125rem;
        border: 2px solid #d1d5db;
        border-radius: 50%;
        margin-right: 0.875rem;
        position: relative;
        flex-shrink: 0;
        cursor: pointer;
    }

    .radio-option-input:checked {
        border-color: #3b82f6;
        background-color: #3b82f6;
    }

    .radio-option-input:checked::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 50%;
        background-color: white;
    }

    .radio-option-label {
        font-weight: 500;
        color: #111827;
        font-size: 0.9375rem;
        cursor: pointer;
        flex-grow: 1;
    }

    .radio-option-desc {
        font-size: 0.8125rem;
        color: #6B7280;
        margin-top: 0.375rem;
        line-height: 1.5;
    }

    /* ====== Professional Checkbox ====== */
    .checkbox-wrapper {
        display: flex;
        align-items: flex-start;
    }

    .checkbox-input {
        appearance: none;
        -webkit-appearance: none;
        width: 1.125rem;
        height: 1.125rem;
        border: 1.5px solid #d1d5db;
        border-radius: 0.25rem;
        margin-right: 0.75rem;
        flex-shrink: 0;
        position: relative;
        cursor: pointer;
        top: 0.125rem;
    }

    .checkbox-input:checked {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }

    .checkbox-input:checked::after {
        content: '✓';
        position: absolute;
        color: white;
        font-size: 0.75rem;
        font-weight: bold;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .checkbox-label {
        font-size: 0.875rem;
        color: #4B5563;
        line-height: 1.5;
        cursor: pointer;
    }

    /* ====== Button Styling ====== */
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        font-weight: 600;
        font-size: 0.9375rem;
        padding: 0.875rem 2rem;
        border-radius: 0.5rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        letter-spacing: 0.025em;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
        box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
        transform: translateY(-1px);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .btn-primary:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.4);
    }

    /* ====== Contact Info Card ====== */
    .contact-card {
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        height: 100%;
    }

    .contact-card-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #f3f4f6;
    }

    .contact-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1.25rem;
    }

    .contact-icon {
        color: #3b82f6;
        font-size: 1rem;
        width: 1.5rem;
        flex-shrink: 0;
        margin-top: 0.125rem;
    }

    .contact-text {
        font-size: 0.9375rem;
        color: #4B5563;
        line-height: 1.5;
    }

    .contact-link {
        color: #3b82f6;
        text-decoration: none;
        transition: color 0.2s;
        word-break: break-all;
    }

    .contact-link:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }

    /* ====== Alert & Notice Boxes ====== */
    .alert-note {
        background-color: #fffbeb;
        border: 1px solid #fef3c7;
        border-left: 4px solid #f59e0b;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .alert-title {
        font-size: 0.875rem;
        font-weight: 700;
        color: #92400e;
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .alert-content {
        font-size: 0.9375rem;
        color: #92400e;
        line-height: 1.6;
    }

    .alert-content strong {
        font-weight: 600;
    }

    .privacy-box {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    /* ====== Utility Classes ====== */
    .required-star {
        color: #ef4444;
        margin-left: 0.125rem;
    }

    .form-hint {
        font-size: 0.8125rem;
        color: #6B7280;
        margin-top: 0.375rem;
        font-style: italic;
    }

    .error-message {
        font-size: 0.8125rem;
        color: #ef4444;
        margin-top: 0.375rem;
    }

    .divider {
        border: none;
        border-top: 1px solid #e5e7eb;
        margin: 2rem 0;
    }

    /* ====== Responsive Grid ====== */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 1.5rem;
    }

    @media (min-width: 640px) {
        .form-grid-2 {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* ====== Animation ====== */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out;
    }
</style>

