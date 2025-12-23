@extends('front.layouts.inner')
@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')

<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Breadcrumbs -->
        <nav class="text-sm mb-8">
            <ol class="flex text-gray-600">
                <li><a href="{{ url('/') }}" class="hover:underline">Home</a></li>
                <li class="mx-2">/</li>
                <li><a href="{{ route('products.index', $product->productGroup->slug) }}" class="hover:underline">{{ $product->productGroup->name }}</a></li>
                <li class="mx-2">/</li>
                <li class="text-gray-800 font-medium">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- LEFT COLUMN (70%) -->
            <div class="lg:w-7/12">
                <!-- Product Header -->
                <div class="mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">
                        {{ $product->name }}
                    </h1>
                    
                    <div class="flex gap-3 mb-6">
                        @if($product->badge)
                            <span class="bg-red-600 text-white text-sm font-semibold px-4 py-1.5 rounded-full">
                                {{ $product->badge }}
                            </span>
                        @endif
                        @if($product->certifications)
                            <span class="bg-blue-600 text-white text-sm font-semibold px-4 py-1.5 rounded-full">
                                {{ $product->certifications }}
                            </span>
                        @endif
                    </div>

                    @if($product->short_description)
                        <p class="text-gray-700 text-lg mb-6">
                            {{ $product->short_description }}
                        </p>
                    @endif
                </div>

                <!-- Product Image -->
                @if($product->details && $product->details->image)
                <div class="mb-10 bg-white rounded-xl shadow-lg p-6">
                    <img src="{{ asset('storage/' . $product->details->image) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-auto max-h-96 object-contain rounded-lg">
                </div>
                @endif

                <!-- PRODUCT feature -->
                @if($product->features->where('is_active', true)->count() > 0)
                <div class="mb-12">
                   
                    
                    <div class="space-y-10">
                        @foreach($product->features->where('is_active', true)->sortBy('sort_order') as $feature)
                        <div class="bg-white rounded-xl p-8 shadow-lg border border-gray-200">
                            <!-- Feature Title -->
                            <div class="flex items-center gap-4 mb-6">
                                @if($feature->icon)
                                    <div class="h-14 w-14 rounded-xl flex items-center justify-center shadow-lg"
                                         style="background: linear-gradient(135deg, {{ $feature->color ?? '#3b82f6' }} 0%, {{ $feature->color ?? '#2563eb' }} 100%)">
                                        <i class="{{ $feature->icon }} text-2xl text-white"></i>
                                    </div>
                                @endif
                                <h3 class="text-2xl font-bold text-gray-900 uppercase tracking-tight">
                                    {{ $feature->title }}
                                </h3>
                            </div>
                            
                            <!-- Bullet Points -->
                            @if($feature->description)
                            <div class="space-y-4 pl-4">
                                @foreach(explode("\n", $feature->description) as $line)
                                    @if(trim($line))
                                    <div class="flex">
                                        <span class="text-blue-600 text-xl mr-4">•</span>
                                        <span class="text-gray-700 text-lg flex-1">{{ trim($line) }}</span>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                            @endif
                            
                            <!-- Download Link -->
                            @if($feature->download_link)
                            <div class="mt-8 pt-8 border-t">
                                <a href="{{ asset('storage/' . $feature->download_link) }}" 
                                   target="_blank"
                                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition shadow-lg">
                                    <i class="fas fa-download mr-3"></i>
                                    {{ $feature->download_label ?? 'Download Laboratory Workflow' }}
                                </a>
                                
                                @php
                                    $fileSize = Storage::disk('public')->exists($feature->download_link) 
                                        ? round(Storage::disk('public')->size($feature->download_link) / 1024, 2) . ' KB'
                                        : '';
                                @endphp
                                
                                @if($fileSize)
                                    <p class="mt-2 text-sm text-gray-500">
                                        <i class="fas fa-file-pdf mr-1"></i> PDF, [{{ $fileSize }}]
                                    </p>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Product Description -->
                @if($product->details && $product->details->description)
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Description</h2>
                    <div class="prose max-w-none text-gray-700 text-lg leading-relaxed bg-white p-8 rounded-xl shadow-lg">
                        {!! $product->details->description !!}
                    </div>
                </div>
                @endif

                <!-- Second Image -->
                @if($product->details && $product->details->second_image)
                <div class="mb-12 bg-white rounded-xl shadow-lg p-8">
                    <img src="{{ asset('storage/' . $product->details->second_image) }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-auto max-h-96 object-contain rounded-lg mx-auto"
                         onerror="this.style.display='none'">
                </div>
                @endif

                <!-- Order Information Table -->
                @if($product->details && $product->details->order_table && count(json_decode($product->details->order_table, true)) > 0)
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Order information</h2>
                    
                   <a href="{{ url('/contact') }}" 
   class="inline-flex items-center px-8 py-4 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition text-lg shadow-lg">
    <i class="fas fa-envelope mr-3"></i>
    Get a Price Quote
</a>
                    
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <table class="w-full border-collapse">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="text-left py-4 px-6 font-bold text-gray-700 border-b">Product name</th>
                                    <th class="text-left py-4 px-6 font-bold text-gray-700 border-b">REF</th>
                                    <th class="text-left py-4 px-6 font-bold text-gray-700 border-b">Technology</th>
                                    <th class="text-left py-4 px-6 font-bold text-gray-700 border-b">Packaging</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(json_decode($product->details->order_table, true) as $row)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4 px-6 border-b">{{ $row['name'] ?? '' }}</td>
                                    <td class="py-4 px-6 border-b">{{ $row['ref'] ?? '' }}</td>
                                    <td class="py-4 px-6 border-b">{{ $row['technology'] ?? '' }}</td>
                                    <td class="py-4 px-6 border-b whitespace-pre-line">{{ $row['packaging'] ?? '' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

             <!-- Product Leaflets Section -->
@php
    $leaflets = $product->documents->where('category', 'product_leaflet')->where('is_active', true)->sortBy('sort_order');
@endphp

@if($leaflets->count() > 0)
<div class="mb-12">
    <h2 class="text-3xl font-bold text-gray-900 mb-6">Product Leaflet</h2>
    
    <div class="bg-white rounded-xl shadow-lg p-8">
        <!-- Leaflets List -->
        <div class="space-y-4 mb-8">
            @foreach($leaflets as $leaflet)
            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 leaflet-item">
                <div class="flex items-center">
                    <input type="checkbox" 
                           name="leaflet[]" 
                           value="{{ $leaflet->id }}" 
                           class="leaflet-checkbox h-5 w-5 text-blue-600 rounded mr-4"
                           data-url="{{ asset('storage/' . $leaflet->file_path) }}"
                           data-name="{{ $leaflet->title }}">
                    <div class="flex items-center">
                        <div class="mr-4">
                            <i class="fas fa-file-pdf text-red-500 text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">{{ $leaflet->title }}</h4>
                            @php
                                $fileSize = Storage::disk('public')->exists($leaflet->file_path) 
                                    ? round(Storage::disk('public')->size($leaflet->file_path) / 1024, 2) . ' KB'
                                    : 'Unknown size';
                            @endphp
                            <div class="flex items-center mt-1 text-sm text-gray-500">
                                <span>pdf, [{{ $fileSize }}]</span>
                                <span class="mx-2">•</span>
                                <a href="{{ asset('storage/' . $leaflet->file_path) }}" 
                                   target="_blank"
                                   class="text-blue-600 hover:text-blue-800 hover:underline">
                                    open
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- REMOVED individual download button -->
            </div>
            @endforeach
        </div>
        
        <!-- Bottom Section with Choose All and Download Button -->
        <div class="border-t pt-8">
            <!-- Choose All Checkbox -->
            <div class="flex items-center mb-6">
                <input type="checkbox" id="select-all-leaflets" class="h-5 w-5 text-blue-600 rounded">
                <label for="select-all-leaflets" class="ml-3 text-lg font-medium text-gray-900 cursor-pointer">
                    Choose all
                </label>
            </div>
            
            <!-- Bulk Download Button (Hidden by default) -->
            <div id="bulk-download-container" class="hidden">
                <div class="flex items-center justify-between bg-gray-50 p-4 rounded-lg">
                    <div>
                        <span id="selected-count" class="font-medium text-gray-900">0</span>
                        <span class="text-gray-600"> documents selected</span>
                    </div>
                    <button id="bulk-download-btn"
                            class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>
                        <i class="fas fa-download mr-3"></i>
                        Download (<span id="download-count">0</span>) documents
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
            </div><!-- END LEFT COLUMN -->
<!-- RIGHT COLUMN (30%) -->
<div class="lg:w-5/12">
    <!-- Related Products Card -->
    <div class="sticky top-8 space-y-8">
        <!-- Related Products Card -->
        <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900">{{ $product->productGroup->name ?? 'Related Products' }}</h3>
                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-link text-blue-600 text-lg"></i>
                </div>
            </div>
            
            <div class="space-y-4">
                @if(isset($relatedProducts) && $relatedProducts->count() > 0)
                    @foreach($relatedProducts as $related)
                        <a href="{{ route('products.show', $related->slug) }}" 
                           class="flex items-center gap-4 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-blue-200 transition-all duration-300 group">
                            <div class="h-16 w-16 bg-blue-50 rounded-lg flex items-center justify-center group-hover:bg-blue-100 transition">
                                @if($related->image)
                                    <img src="{{ asset('storage/' . $related->image) }}" 
                                         alt="{{ $related->name }}"
                                         class="h-12 w-12 object-contain">
                                @else
                                    <i class="fas fa-vial text-blue-600 text-xl"></i>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 group-hover:text-blue-700 transition">{{ $related->name }}</h4>
                                @if($related->short_description)
                                    <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $related->short_description }}</p>
                                @endif
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600 transition"></i>
                        </a>
                    @endforeach
                @else
                    <!-- Fallback static examples -->
                    <div class="flex items-center gap-4 p-4 border border-gray-200 rounded-lg">
                        <div class="h-16 w-16 bg-blue-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-vial text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Hepatitis C Virus (HCV)</h4>
                            <p class="text-sm text-gray-500">Diagnostic PCR Kit</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4 p-4 border border-gray-200 rounded-lg">
                        <div class="h-16 w-16 bg-red-50 rounded-lg flex items-center justify-center">
                            <i class="fas fa-virus text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">HIV type 1 (HIV-1)</h4>
                            <p class="text-sm text-gray-500">Diagnostic PCR Kit</p>
                        </div>
                    </div>
                @endif
            </div>
            
            @if($product->productGroup)
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <a href="{{ route('products.index', $product->productGroup->slug) }}" 
                       class="text-blue-600 font-medium hover:text-blue-800 flex items-center group">
                        <span>View all {{ $product->productGroup->name }} products</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            @endif
        </div>

        <!-- SPACING BETWEEN SECTIONS -->
        <div class="h-8"></div>

       <!-- Order Information Card -->
@php
    $orderInfo = App\Models\OrderInformation::first();
@endphp

@if($orderInfo)
<div class="bg-gradient-to-br from-blue-50 to-white rounded-xl shadow-lg p-8 border border-blue-100">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-2xl font-bold text-gray-900">Order Information</h3>
        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
            <i class="fas fa-shopping-cart text-blue-700 text-lg"></i>
        </div>
    </div>
    
    <div class="space-y-6">
        <!-- Sales Contact -->
        @if($orderInfo->show_sales_section)
        <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-phone-alt text-blue-700 text-lg"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 text-lg">Sales & Orders</h4>
                    <p class="text-sm text-gray-500">Contact our sales team</p>
                </div>
            </div>
            
            <div class="space-y-3">
                @if($orderInfo->sales_phone)
                <div class="flex items-center">
                    <i class="fas fa-phone text-blue-600 w-5 mr-3"></i>
                    <div>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $orderInfo->sales_phone) }}" 
                           class="text-gray-800 font-medium hover:text-blue-700 transition">
                            {{ $orderInfo->sales_phone }}
                        </a>
                        <p class="text-xs text-gray-500 mt-1">Office Line</p>
                    </div>
                </div>
                @endif
                
                @if($orderInfo->sales_email)
                <div class="flex items-center">
                    <i class="fas fa-envelope text-blue-600 w-5 mr-3"></i>
                    <div>
                        <a href="mailto:{{ $orderInfo->sales_email }}" 
                           class="text-gray-800 font-medium hover:text-blue-700 transition">
                            {{ $orderInfo->sales_email }}
                        </a>
                        <p class="text-xs text-gray-500 mt-1">Email inquiries</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
        
        <!-- Technical Support -->
        @if($orderInfo->show_support_section)
        <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-headset text-green-700 text-lg"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 text-lg">Technical Support</h4>
                    <p class="text-sm text-gray-500">Expert consultation</p>
                </div>
            </div>
            
            <div class="flex items-center">
                <i class="fas fa-phone text-green-600 w-5 mr-3"></i>
                <div>
                    @if($orderInfo->support_phone)
                    <p class="text-gray-800 font-medium">{{ $orderInfo->support_phone }}</p>
                    @endif
                    @if($orderInfo->support_hours)
                    <p class="text-xs text-gray-500 mt-1">{{ $orderInfo->support_hours }}</p>
                    @endif
                </div>
            </div>
        </div>
        @endif
        
        <!-- Company Address -->
        @if($orderInfo->show_address_section)
        <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
            <div class="flex items-start">
                <i class="fas fa-map-marker-alt text-gray-600 w-5 mr-3 mt-1"></i>
                <div>
                    <h4 class="font-bold text-gray-900 mb-2">Our Location</h4>
                    @if($orderInfo->company_address)
                    <address class="text-gray-700 text-sm leading-relaxed not-italic whitespace-pre-line">
                        {{ $orderInfo->company_address }}
                    </address>
                    @endif
                    @if($orderInfo->company_website)
                    <p class="text-xs text-gray-500 mt-3">
                        <i class="fas fa-globe mr-1"></i>
                        <a href="{{ $orderInfo->company_website }}" target="_blank" 
                           class="text-blue-600 hover:text-blue-800">
                            {{ parse_url($orderInfo->company_website, PHP_URL_HOST) ?? $orderInfo->company_website }}
                        </a>
                    </p>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
    
    <!-- Quick Contact Button -->
    <div class="mt-8 pt-8 border-t border-blue-200">
        <a href="{{ url($orderInfo->contact_button_link) }}" 
           class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold py-4 px-6 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 flex items-center justify-center shadow-md hover:shadow-lg">
            <i class="fas fa-envelope mr-3"></i>
            {{ $orderInfo->contact_button_text }}
        </a>
        <p class="text-center text-sm text-gray-500 mt-3">
            Response within 24 hours
        </p>
    </div>
</div>
@endif
    </div>
</div><!-- END RIGHT COLUMN -->
    </div>
</section>

<!-- JavaScript for Leaflet Selection -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('select-all-leaflets');
        const leafletCheckboxes = document.querySelectorAll('.leaflet-checkbox');
        const bulkDownloadContainer = document.getElementById('bulk-download-container');
        const bulkDownloadBtn = document.getElementById('bulk-download-btn');
        const selectedCountSpan = document.getElementById('selected-count');
        const downloadCountSpan = document.getElementById('download-count');
        
        // Select All functionality
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                leafletCheckboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
                updateBulkDownload();
            });
        }
        
        // Individual checkbox change
        leafletCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkDownload);
        });
        
        // Update bulk download UI
        function updateBulkDownload() {
            const checkedBoxes = Array.from(leafletCheckboxes).filter(cb => cb.checked);
            const count = checkedBoxes.length;
            
            // Update counts
            selectedCountSpan.textContent = count;
            downloadCountSpan.textContent = count;
            
            // Show/hide bulk download container
            if (count > 0) {
                bulkDownloadContainer.classList.remove('hidden');
                bulkDownloadBtn.disabled = false;
            } else {
                bulkDownloadContainer.classList.add('hidden');
                bulkDownloadBtn.disabled = true;
            }
            
            // Update "Select All" checkbox
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = count === leafletCheckboxes.length;
            }
        }
        
        // Bulk download functionality
        if (bulkDownloadBtn) {
            bulkDownloadBtn.addEventListener('click', function() {
                const checkedBoxes = Array.from(leafletCheckboxes).filter(cb => cb.checked);
                
                if (checkedBoxes.length === 1) {
                    // Single file - direct download
                    const url = checkedBoxes[0].dataset.url;
                    window.open(url, '_blank');
                } else {
                    // Multiple files - download one by one
                    checkedBoxes.forEach((checkbox, index) => {
                        setTimeout(() => {
                            window.open(checkbox.dataset.url, '_blank');
                        }, index * 500); // Delay to avoid popup blocking
                    });
                    
                    // Show success message
                    alert(`Downloading ${checkedBoxes.length} documents. Please allow popups.`);
                }
            });
        }
        
        // Single download buttons
        document.querySelectorAll('.leaflet-download-single').forEach(button => {
            button.addEventListener('click', function(e) {
                // Don't prevent default - let the link work normally
            });
        });
    });
</script>

@endsection