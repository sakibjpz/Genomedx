@extends('admin.layouts.app')

@section('title', 'Record Response - Query #' . $contactQuery->id)

@section('content')
<div class="container mx-auto p-4 max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.contact-queries.show', $contactQuery->id) }}" class="text-blue-600 hover:text-blue-800">
            ← Back to query
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Record Response</h1>
        <p class="text-gray-600 mb-6">Query #{{ $contactQuery->id }} - {{ $contactQuery->query_type }}</p>

        <!-- Customer Info -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <h3 class="font-semibold text-gray-900 mb-2">Customer Information</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p><span class="font-medium">Name:</span> {{ $contactQuery->name }}</p>
                    <p><span class="font-medium">Email:</span> {{ $contactQuery->email }}</p>
                    <p><span class="font-medium">Phone:</span> {{ $contactQuery->phone ?? 'Not provided' }}</p>
                </div>
                <div>
                    <p><span class="font-medium">Company:</span> {{ $contactQuery->company }}</p>
                    <p><span class="font-medium">Query Type:</span> {{ $contactQuery->query_type }}</p>
                    <p><span class="font-medium">Status:</span> 
                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $contactQuery->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($contactQuery->status == 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                               'bg-green-100 text-green-800') }}">
                            {{ ucfirst($contactQuery->status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Response Form -->
        <form action="{{ route('admin.contact-queries.record-response', $contactQuery->id) }}" method="POST">
            @csrf
            
            <!-- Response Type -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Response Type *</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="flex items-center">
                        <input type="radio" id="type_email" name="type" value="email" class="h-4 w-4 text-blue-600" checked>
                        <label for="type_email" class="ml-2 text-gray-700">Email</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" id="type_phone" name="type" value="phone" class="h-4 w-4 text-blue-600">
                        <label for="type_phone" class="ml-2 text-gray-700">Phone Call</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" id="type_message" name="type" value="message" class="h-4 w-4 text-blue-600">
                        <label for="type_message" class="ml-2 text-gray-700">Message</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" id="type_internal_note" name="type" value="internal_note" class="h-4 w-4 text-blue-600">
                        <label for="type_internal_note" class="ml-2 text-gray-700">Internal Note</label>
                    </div>
                </div>
            </div>

            <!-- Response Content -->
            <div class="mb-6">
                <label for="content" class="block text-gray-700 font-medium mb-2">Response Content *</label>
                <textarea id="content" name="content" rows="8" required
                          class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Enter the response details..."></textarea>
                <p class="text-sm text-gray-500 mt-1">
                    Include all relevant details of the response. For emails, include the email content.
                </p>
            </div>

            <!-- Customer Notification -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" id="customer_notified" name="customer_notified" value="1" 
                           class="h-4 w-4 text-blue-600" checked>
                    <label for="customer_notified" class="ml-2 text-gray-700">
                        Customer was notified of this response
                    </label>
                </div>
                <p class="text-sm text-gray-500 mt-1">
                    Uncheck if this is an internal note not shared with the customer.
                </p>
            </div>

            <!-- Update Status -->
            <div class="mb-8">
                <label for="update_status" class="block text-gray-700 font-medium mb-2">Update Query Status</label>
                <select id="update_status" name="update_status" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Keep current status ({{ $contactQuery->status }})</option>
                    <option value="in_progress">Mark as In Progress</option>
                    <option value="resolved">Mark as Resolved</option>
                </select>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.contact-queries.show', $contactQuery->id) }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                    Record Response
                </button>
            </div>
        </form>
    </div>

    <!-- Previous Responses -->
    @if($contactQuery->responses->count() > 0)
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Previous Responses</h2>
        <div class="space-y-4">
            @foreach($contactQuery->responses->sortByDesc('responded_at') as $response)
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <span class="font-medium text-gray-900">{{ $response->user->name ?? 'System' }}</span>
                        <span class="text-sm text-gray-600 ml-2">
                            via {{ ucfirst(str_replace('_', ' ', $response->type)) }}
                        </span>
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $response->responded_at->format('M d, Y H:i') }}
                    </div>
                </div>
                <div class="bg-gray-50 rounded p-3 mt-2">
                    <p class="text-gray-700 whitespace-pre-line">{{ $response->content }}</p>
                </div>
                @if(!$response->customer_notified)
                    <div class="mt-2">
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Internal Note</span>
                    </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection