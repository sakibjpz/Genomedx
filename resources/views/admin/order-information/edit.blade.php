@extends('admin.layouts.app')

@section('title', 'Edit Order Information')

@section('content')
<div class="container mx-auto p-6">
    <div class="max-w-4xl mx-auto">
        
        <h1 class="text-2xl font-bold mb-6">Edit Order Information</h1>
        
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form action="{{ route('admin.order-information.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Sales Section -->
                    <div class="md:col-span-2">
                        <div class="flex items-center mb-4">
                            <input type="checkbox" name="show_sales_section" id="show_sales_section" 
                                   value="1" {{ $orderInfo->show_sales_section ? 'checked' : '' }} class="mr-2">
                            <label for="show_sales_section" class="text-lg font-semibold text-gray-900">
                                Sales & Orders Section
                            </label>
                        </div>
                        
                        <div class="ml-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Sales Phone Number
                                </label>
                                <input type="text" name="sales_phone" value="{{ old('sales_phone', $orderInfo->sales_phone) }}"
                                       class="w-full border border-gray-300 rounded-lg p-3">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Sales Email
                                </label>
                                <input type="email" name="sales_email" value="{{ old('sales_email', $orderInfo->sales_email) }}"
                                       class="w-full border border-gray-300 rounded-lg p-3">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Support Section -->
                    <div class="md:col-span-2">
                        <div class="flex items-center mb-4">
                            <input type="checkbox" name="show_support_section" id="show_support_section" 
                                   value="1" {{ $orderInfo->show_support_section ? 'checked' : '' }} class="mr-2">
                            <label for="show_support_section" class="text-lg font-semibold text-gray-900">
                                Technical Support Section
                            </label>
                        </div>
                        
                        <div class="ml-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Support Info
                                </label>
                                <input type="text" name="support_phone" value="{{ old('support_phone', $orderInfo->support_phone) }}"
                                       placeholder="e.g., Available 9 AM - 6 PM"
                                       class="w-full border border-gray-300 rounded-lg p-3">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Support Hours
                                </label>
                                <input type="text" name="support_hours" value="{{ old('support_hours', $orderInfo->support_hours) }}"
                                       placeholder="e.g., Sunday - Thursday"
                                       class="w-full border border-gray-300 rounded-lg p-3">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Address Section -->
                    <div class="md:col-span-2">
                        <div class="flex items-center mb-4">
                            <input type="checkbox" name="show_address_section" id="show_address_section" 
                                   value="1" {{ $orderInfo->show_address_section ? 'checked' : '' }} class="mr-2">
                            <label for="show_address_section" class="text-lg font-semibold text-gray-900">
                                Company Address Section
                            </label>
                        </div>
                        
                        <div class="ml-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Company Address
                                </label>
                                <textarea name="company_address" rows="4"
                                          class="w-full border border-gray-300 rounded-lg p-3">{{ old('company_address', $orderInfo->company_address) }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Use new lines for formatting</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Company Website
                                </label>
                                <input type="url" name="company_website" value="{{ old('company_website', $orderInfo->company_website) }}"
                                       placeholder="https://www.genomedxbd.com"
                                       class="w-full border border-gray-300 rounded-lg p-3">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Button -->
                    <div class="md:col-span-2 border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Button</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Button Text
                                </label>
                                <input type="text" name="contact_button_text" 
                                       value="{{ old('contact_button_text', $orderInfo->contact_button_text) }}"
                                       placeholder="e.g., Request Quote / Contact"
                                       class="w-full border border-gray-300 rounded-lg p-3">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Button Link
                                </label>
                                <input type="text" name="contact_button_link" 
                                       value="{{ old('contact_button_link', $orderInfo->contact_button_link) }}"
                                       placeholder="/contact or http://..."
                                       class="w-full border border-gray-300 rounded-lg p-3">
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <!-- Submit Button -->
                <div class="mt-8 pt-6 border-t">
                    <button type="submit" 
                            class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                        Update Order Information
                    </button>
                    
                    <a href="{{ url('/') }}" target="_blank"
                       class="ml-4 px-6 py-3 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition">
                        View Live
                    </a>
                </div>
                
            </form>
        </div>
        
        <!-- Preview Section -->
        <div class="mt-10">
            <h3 class="text-xl font-bold mb-4">Preview</h3>
            <div class="bg-gray-100 p-6 rounded-xl">
                <div class="max-w-md mx-auto">
                    @include('partials.order-information-preview')
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection