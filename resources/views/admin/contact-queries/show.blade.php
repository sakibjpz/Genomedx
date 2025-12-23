@extends('admin.layouts.app')

@section('title', 'Contact Query #' . $contactQuery->id)

@section('content')
<div class="container mx-auto p-4">
    <div class="mb-6">
        <a href="{{ route('admin.contact-queries.index') }}" class="text-blue-600 hover:text-blue-800">
            ← Back to queries
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Query Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Query Details Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Query #{{ $contactQuery->id }}</h1>
                        <p class="text-gray-600">Submitted on {{ $contactQuery->created_at->format('F d, Y H:i') }}</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <!-- Status Badge -->
                        <span class="px-3 py-1 text-sm font-semibold rounded-full 
                            {{ $contactQuery->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($contactQuery->status == 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                               'bg-green-100 text-green-800') }}">
                            {{ ucfirst(str_replace('_', ' ', $contactQuery->status)) }}
                        </span>

                        <!-- Query Type Badge -->
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $contactQuery->query_type }}
                        </span>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Customer Information</h3>
                        <div class="space-y-2">
                            <p><span class="font-medium">Name:</span> {{ $contactQuery->name }}</p>
                            <p><span class="font-medium">Email:</span> {{ $contactQuery->email }}</p>
                            <p><span class="font-medium">Phone:</span> {{ $contactQuery->phone ?? 'Not provided' }}</p>
                            <p><span class="font-medium">Company:</span> {{ $contactQuery->company }}</p>
                            <p><span class="font-medium">Profile:</span> {{ $contactQuery->profile }}</p>
                            <p><span class="font-medium">Country:</span> {{ $contactQuery->country }}</p>
                        </div>
                    </div>

                    <!-- Team Assignment -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Team Assignment</h3>
                        @if($contactQuery->assignment)
                            <div class="space-y-2">
                                <p>
                                    <span class="font-medium">Team:</span> 
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $contactQuery->assignment->team->name == 'Sales' ? 'bg-green-100 text-green-800' : 
                                           ($contactQuery->assignment->team->name == 'Technical Support' ? 'bg-yellow-100 text-yellow-800' : 
                                           'bg-gray-100 text-gray-800') }}">
                                        {{ $contactQuery->assignment->team->name }}
                                    </span>
                                </p>
                                <p>
                                    <span class="font-medium">Assigned to:</span> 
                                    {{ $contactQuery->assignment->assignee ? $contactQuery->assignment->assignee->name : 'Not assigned to user' }}
                                </p>
                                <p><span class="font-medium">Assigned at:</span> 
                                    {{ $contactQuery->assignment->assigned_at->format('M d, Y H:i') }}
                                </p>
                                @if($contactQuery->assignment->resolved_at)
                                    <p><span class="font-medium">Resolved at:</span> 
                                        {{ $contactQuery->assignment->resolved_at->format('M d, Y H:i') }}
                                    </p>
                                @endif
                            </div>
                        @else
                            <p class="text-gray-500">Not assigned to any team</p>
                        @endif
                    </div>
                </div>

                <!-- Message -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Message</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700 whitespace-pre-line">{{ $contactQuery->message }}</p>
                    </div>
                </div>

                <!-- Responses History -->
                @if($contactQuery->responses->count() > 0)
                <div class="mt-8 pt-8 border-t">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Response History</h3>
                    <div class="space-y-4">
                        @foreach($contactQuery->responses->sortByDesc('responded_at') as $response)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <span class="font-medium text-gray-900">{{ $response->user->name ?? 'System' }}</span>
                                    <span class="text-sm text-gray-600 ml-2">
                                        via {{ ucfirst(str_replace('_', ' ', $response->type)) }}
                                    </span>
                                    @if(!$response->customer_notified)
                                        <span class="ml-2 text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Internal Note</span>
                                    @endif
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $response->responded_at->format('M d, Y H:i') }}
                                </div>
                            </div>
                            <div class="bg-gray-50 rounded p-3 mt-2">
                                <p class="text-gray-700 whitespace-pre-line">{{ $response->content }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Column: Actions -->
        <div class="space-y-6">
            <!-- Status Update Form -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Update Status</h3>
                <form action="{{ route('admin.contact-queries.update-status', $contactQuery->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ $contactQuery->status == $status ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Update Status
                    </button>
                </form>
            </div>

            <!-- Assign to User Form -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Assign to Team Member</h3>
                <form action="{{ route('admin.contact-queries.assign', $contactQuery->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <select name="user_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select team member</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" 
                                    {{ $contactQuery->assignment && $contactQuery->assignment->assigned_to == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        Assign to User
                    </button>
                </form>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <!-- Record Response Button -->
                    <a href="{{ route('admin.contact-queries.show-response-form', $contactQuery->id) }}"
                       class="block w-full text-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-reply mr-2"></i>Record Response
                    </a>
                    
                    <a href="mailto:{{ $contactQuery->email }}" 
                       class="block w-full text-center bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                        <i class="fas fa-envelope mr-2"></i>Reply via Email
                    </a>
                    <button onclick="window.location.reload()" 
                            class="w-full bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                        <i class="fas fa-sync-alt mr-2"></i>Refresh Page
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection