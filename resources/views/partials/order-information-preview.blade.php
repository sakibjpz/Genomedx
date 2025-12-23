<div class="bg-gradient-to-br from-blue-50 to-white rounded-xl shadow-lg p-6 border border-blue-100">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-bold text-gray-900">Order Information</h3>
        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
            <i class="fas fa-shopping-cart text-blue-700"></i>
        </div>
    </div>
    
    <div class="space-y-4 text-sm">
        @if($orderInfo->show_sales_section && ($orderInfo->sales_phone || $orderInfo->sales_email))
        <div class="bg-white p-4 rounded border">
            <div class="font-semibold text-gray-900 mb-2">Sales & Orders</div>
            @if($orderInfo->sales_phone)
            <div class="flex items-center text-gray-700 mb-1">
                <i class="fas fa-phone text-blue-600 w-4 mr-2"></i>
                {{ $orderInfo->sales_phone }}
            </div>
            @endif
            @if($orderInfo->sales_email)
            <div class="flex items-center text-gray-700">
                <i class="fas fa-envelope text-blue-600 w-4 mr-2"></i>
                {{ $orderInfo->sales_email }}
            </div>
            @endif
        </div>
        @endif
        
        @if($orderInfo->show_support_section && ($orderInfo->support_phone || $orderInfo->support_hours))
        <div class="bg-white p-4 rounded border">
            <div class="font-semibold text-gray-900 mb-2">Technical Support</div>
            @if($orderInfo->support_phone)
            <div class="text-gray-700 mb-1">{{ $orderInfo->support_phone }}</div>
            @endif
            @if($orderInfo->support_hours)
            <div class="text-gray-500 text-xs">{{ $orderInfo->support_hours }}</div>
            @endif
        </div>
        @endif
        
        @if($orderInfo->show_address_section && $orderInfo->company_address)
        <div class="bg-white p-4 rounded border">
            <div class="font-semibold text-gray-900 mb-2">Our Location</div>
            <div class="text-gray-700 whitespace-pre-line text-xs">{{ $orderInfo->company_address }}</div>
        </div>
        @endif
    </div>
    
    <div class="mt-6 pt-4 border-t">
        <div class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white text-center py-3 px-4 rounded-lg">
            <i class="fas fa-envelope mr-2"></i>
            {{ $orderInfo->contact_button_text }}
        </div>
    </div>
</div>