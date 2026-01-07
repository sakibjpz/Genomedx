@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto p-4 sm:p-6">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-3">
        <h1 class="text-xl sm:text-2xl font-bold">Team Members</h1>
        <a href="{{ route('admin.team-members.create') }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-center text-sm sm:text-base transition">
            <i class="fas fa-plus mr-1"></i> Add Team Member
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Desktop Table View -->
    <div class="hidden lg:block bg-white rounded shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-sm">Order</th>
                        <th class="text-sm">Image</th>
                        <th class="text-sm">Name</th>
                        <th class="text-sm">Position</th>
                        <th class="text-sm">Regions</th>
                        <th class="text-sm">Email</th>
                        <th class="text-sm">Phone</th>
                        <th class="text-sm">Status</th>
                        <th class="text-sm" style="min-width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody id="sortable">
                    @forelse($teamMembers as $member)
                        <tr data-id="{{ $member->id }}" class="border-t cursor-move hover:bg-gray-50">
                            <td class="p-3">
                                <i class="fas fa-grip-vertical text-gray-400 mr-2"></i>
                                {{ $member->order }}
                            </td>
                            <td>
                                @if($member->image)
                                    <img src="{{ asset('storage/' . $member->image) }}" 
                                         alt="{{ $member->name }}" 
                                         class="w-12 h-12 rounded-full object-cover">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="font-medium text-sm">{{ $member->name }}</td>
                            <td class="text-sm">{{ $member->position }}</td>
                            <td class="text-sm">{{ $member->regions }}</td>
                            <td class="text-sm">{{ $member->email }}</td>
                            <td class="text-sm">{{ $member->phone }}</td>
                            <td>
                                @if($member->status)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Active</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-xs">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.team-members.edit', $member) }}" 
                                       class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.team-members.destroy', $member) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this team member?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-4 text-center text-gray-500">
                                No team members found. Add your first team member.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="lg:hidden space-y-4" id="sortable-mobile">
        @forelse($teamMembers as $member)
        <div data-id="{{ $member->id }}" class="bg-white rounded shadow overflow-hidden">
            <!-- Header with Image and Drag Handle -->
            <div class="p-4 bg-gray-50 border-b flex items-center">
                <i class="fas fa-grip-vertical text-gray-400 text-lg mr-3 cursor-move"></i>
                
                @if($member->image)
                    <img src="{{ asset('storage/' . $member->image) }}" 
                         alt="{{ $member->name }}" 
                         class="w-16 h-16 rounded-full object-cover mr-3 border-2 border-white shadow">
                @else
                    <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center mr-3 border-2 border-white shadow">
                        <i class="fas fa-user text-gray-400 text-xl"></i>
                    </div>
                @endif
                
                <div class="flex-1 min-w-0">
                    <h3 class="text-base font-semibold text-gray-900 truncate">{{ $member->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $member->position }}</p>
                </div>
                
                <span class="ml-2 flex-shrink-0 text-xs font-medium text-gray-500 bg-white px-2 py-1 rounded border">
                    #{{ $member->order }}
                </span>
            </div>

            <!-- Content -->
            <div class="p-4 space-y-3">
                <!-- Regions -->
                <div class="flex items-start">
                    <i class="fas fa-map-marker-alt text-gray-400 text-sm mt-1 mr-3 w-4"></i>
                    <div class="flex-1">
                        <p class="text-xs text-gray-600 mb-1">Regions</p>
                        <p class="text-sm text-gray-900">{{ $member->regions }}</p>
                    </div>
                </div>

                <!-- Email -->
                <div class="flex items-start">
                    <i class="fas fa-envelope text-gray-400 text-sm mt-1 mr-3 w-4"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-gray-600 mb-1">Email</p>
                        <a href="mailto:{{ $member->email }}" class="text-sm text-blue-600 hover:text-blue-800 break-all">
                            {{ $member->email }}
                        </a>
                    </div>
                </div>

                <!-- Phone -->
                <div class="flex items-start">
                    <i class="fas fa-phone text-gray-400 text-sm mt-1 mr-3 w-4"></i>
                    <div class="flex-1">
                        <p class="text-xs text-gray-600 mb-1">Phone</p>
                        <a href="tel:{{ $member->phone }}" class="text-sm text-blue-600 hover:text-blue-800">
                            {{ $member->phone }}
                        </a>
                    </div>
                </div>

                <!-- Status -->
                <div class="flex items-center justify-between pt-3 border-t">
                    <span class="text-xs text-gray-600 font-medium">Status:</span>
                    @if($member->status)
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold">Active</span>
                    @else
                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded text-xs font-semibold">Inactive</span>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="p-4 bg-gray-50 border-t flex gap-2">
                <a href="{{ route('admin.team-members.edit', $member) }}" 
                   class="flex-1 text-center px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm font-medium transition">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <form action="{{ route('admin.team-members.destroy', $member) }}" 
                      method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this team member?')"
                      class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm font-medium transition">
                        <i class="fas fa-trash mr-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="bg-white rounded shadow p-6 text-center">
            <i class="fas fa-users text-4xl text-gray-300 mb-3"></i>
            <p class="text-gray-500 mb-3">No team members found.</p>
            <a href="{{ route('admin.team-members.create') }}" class="inline-block text-blue-600 hover:text-blue-800 text-sm font-medium">
                Add your first team member →
            </a>
        </div>
        @endforelse
    </div>

    <!-- Empty state for desktop -->
    @if($teamMembers->isEmpty())
    <div class="hidden lg:block bg-white rounded shadow p-8 text-center">
        <i class="fas fa-users text-5xl text-gray-300 mb-4"></i>
        <p class="text-gray-500 text-lg mb-4">No team members found.</p>
        <a href="{{ route('admin.team-members.create') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i> Add your first team member
        </a>
    </div>
    @endif
</div>

<!-- Include jQuery for sorting -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
<script>
$(function() {
    // Desktop sortable
    $("#sortable").sortable({
        handle: '.fa-grip-vertical',
        update: function(event, ui) {
            var order = [];
            $('#sortable tr').each(function(index) {
                order.push($(this).data('id'));
            });
            
            $.ajax({
                url: "{{ route('admin.team-members.reorder') }}",
                method: 'POST',
                data: {
                    order: order,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Update order numbers
                    $('#sortable tr').each(function(index) {
                        $(this).find('td:first').html('<i class="fas fa-grip-vertical text-gray-400 mr-2"></i>' + (index + 1));
                    });
                }
            });
        }
    }).disableSelection();

    // Mobile sortable
    $("#sortable-mobile").sortable({
        handle: '.fa-grip-vertical',
        update: function(event, ui) {
            var order = [];
            $('#sortable-mobile > div').each(function(index) {
                order.push($(this).data('id'));
            });
            
            $.ajax({
                url: "{{ route('admin.team-members.reorder') }}",
                method: 'POST',
                data: {
                    order: order,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Update order numbers in mobile view
                    $('#sortable-mobile > div').each(function(index) {
                        $(this).find('.bg-white.px-2.py-1').text('#' + (index + 1));
                    });
                }
            });
        }
    });
});
</script>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* Mobile specific adjustments */
    @media (max-width: 1023px) {
        .container {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
    }

    /* Sortable styling */
    .ui-sortable-helper {
        opacity: 0.8;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* Table hover effect */
    @media (min-width: 1024px) {
        tbody tr:hover {
            background-color: #f9fafb;
        }
    }
</style>
@endsection