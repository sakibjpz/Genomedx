@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">Product Groups</h1>

    {{-- Success Message --}}
    <div id="successMessage" class="mb-4 p-3 bg-green-100 text-green-800 rounded hidden"></div>

    {{-- Create Form --}}
    <div class="bg-white p-6 rounded shadow mb-8">
        <h2 class="text-lg font-semibold mb-4">Add New Group</h2>

        <form method="POST" action="{{ route('admin.product-groups.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Name</label>
                    <input type="text" name="name" class="w-full border rounded p-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Color</label>
                    <div class="flex items-center space-x-2">
                        <select name="color" id="colorSelect" class="w-full border rounded p-2">
                            <option value="red-500" data-color="#ef4444">Red</option>
                            <option value="green-500" data-color="#22c55e">Green</option>
                            <option value="blue-500" data-color="#3b82f6">Blue</option>
                            <option value="orange-500" data-color="#f97316">Orange</option>
                            <option value="purple-600" data-color="#9333ea">Purple</option>
                            <option value="cyan-500" data-color="#06b6d4">Cyan</option>
                            <option value="lime-500" data-color="#84cc16">Lime</option>
                            <option value="amber-700" data-color="#b45309">Amber</option>
                            <option value="gray-400" data-color="#9ca3af">Gray</option>
                        </select>
                        <span id="colorPreview" class="w-6 h-6 rounded border"></span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Icon</label>
                    <input type="file" name="icon" accept=".svg,.png" class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Position</label>
                    <input type="number" name="position" class="w-full border rounded p-2">
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-1">Company (Optional)</label>
                    <select name="company_id" class="w-full border rounded p-2" required>
                        <option value="">-- No Company --</option>
                        @foreach(\App\Models\Company::active()->ordered()->get() as $company)
                            <option value="{{ $company->id }}">
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center mt-6">
                    <input type="checkbox" name="status" value="1" class="mr-2" checked>
                    <label>Active</label>
                </div>

            </div>

            <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded">
                Save Group
            </button>
        </form>
    </div>

    {{-- Groups Table --}}
    <div class="bg-white rounded shadow">
        <table class="w-full text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">#</th>
                    <th>Icon</th>
                    <th>Name</th>
                    <th>Company</th>
                    <th>Color</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Actions</th> 
                </tr>
            </thead>
          <tbody>
    @forelse($groups as $group)
        <tr class="border-t" id="group-{{ $group->id }}">
            <td class="p-3">{{ $loop->iteration }}</td>

            <td>
                @if($group->icon)
                    <img src="{{ asset('storage/'.$group->icon) }}" alt="{{ $group->name }}" class="w-8 h-8">
                @else
                    -
                @endif
            </td>

            <td class="group-name">{{ $group->name }}</td>

            <!-- ADD THIS COMPANY COLUMN -->
            <td>
                @if($group->company)
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-sm">
                        {{ $group->company->name }}
                    </span>
                @else
                    <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded text-sm">
                        No Company
                    </span>
                @endif
            </td>

            <td>
                <span class="w-6 h-6 inline-block rounded border group-color" 
                      style="background-color: {{ $group->colorHex() }}"></span>
            </td>

            <td>{{ $group->slug }}</td>

            <td class="group-status">{{ $group->status ? 'Active' : 'Inactive' }}</td>

            <td class="space-x-2">
                <button class="edit-group px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition"
                        data-id="{{ $group->id }}"
                        data-name="{{ $group->name }}"
                        data-color="{{ $group->color }}"
                        data-position="{{ $group->position }}"
                        data-status="{{ $group->status }}"
                        data-company-id="{{ $group->company_id }}">
                    Edit
                </button>

                <button class="delete-group px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition"
                        data-id="{{ $group->id }}">
                    Delete
                </button>
                <a href="{{ route('admin.product-groups.products.create', $group->id) }}"
                   style="background-color: #10b981; color: white; padding: 4px 8px; border-radius: 4px; display: inline-flex; align-items: center;"
                   class="inline-flex items-center px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition">
                    Add Product
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="p-4 text-center text-gray-500"> <!-- Change colspan to 8 -->
                No product groups yet.
            </td>
        </tr>
    @endforelse
</tbody>
        </table>
    </div>

</div>

{{-- Edit Modal --}}
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded p-6 w-96 relative">
        <h2 class="text-lg font-semibold mb-4">Edit Product Group</h2>
        <form id="editForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input type="hidden" name="group_id" id="editGroupId">

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Name</label>
                <input type="text" name="name" id="editName" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Color</label>
                <select name="color" id="editColor" class="w-full border rounded p-2">
                    @foreach(['red-500','green-500','blue-500','orange-500','purple-600','cyan-500','lime-500','amber-700','gray-400'] as $color)
                        <option value="{{ $color }}">{{ ucfirst($color) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Icon</label>
                <input type="file" name="icon" id="editIcon" accept=".svg,.png" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Position</label>
                <input type="number" name="position" id="editPosition" class="w-full border rounded p-2">
            </div>

            {{-- Company Dropdown --}}
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Company</label>
                <select name="company_id" id="editCompanyId" class="w-full border rounded p-2">
                    <option value="">-- No Company --</option>
                    @foreach(\App\Models\Company::active()->ordered()->get() as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center mb-4">
                <input type="checkbox" name="status" id="editStatus" value="1" class="mr-2">
                <label>Active</label>
            </div>

          <div class="flex justify-end space-x-2 mt-6">
   <button type="button" id="closeModal" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition">Cancel</button>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Update</button>
</div>
        </form>
    </div>
</div>

{{-- JS --}}
<script>
    // Color preview for new group
    const colorSelect = document.getElementById('colorSelect');
    const colorPreview = document.getElementById('colorPreview');
    function updateColorPreview() {
        const selectedOption = colorSelect.options[colorSelect.selectedIndex];
        const colorHex = selectedOption.getAttribute('data-color');
        colorPreview.style.backgroundColor = colorHex;
    }
    colorSelect.addEventListener('change', updateColorPreview);
    updateColorPreview();

    // AJAX Delete
    document.querySelectorAll('.delete-group').forEach(button => {
        button.addEventListener('click', function() {
            const groupId = this.dataset.id;
            if (!confirm('Are you sure you want to delete this group?')) return;

            fetch(`/admin/product-groups/${groupId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`group-${groupId}`).remove();
                } else {
                    alert('Failed to delete. Please try again.');
                }
            })
            .catch(err => {
                console.error(err);
                alert('An error occurred. Please try again.');
            });
        });
    });

    // Open Edit Modal
    const editModal = document.getElementById('editModal');
    const closeModal = document.getElementById('closeModal');
    const editForm = document.getElementById('editForm');

    document.querySelectorAll('.edit-group').forEach(button => {
        button.addEventListener('click', function() {
            const groupId = this.dataset.id;
            document.getElementById('editGroupId').value = groupId;
            document.getElementById('editName').value = this.dataset.name;
            document.getElementById('editColor').value = this.dataset.color;
            document.getElementById('editPosition').value = this.dataset.position;
            document.getElementById('editCompanyId').value = this.dataset.companyId;
            document.getElementById('editStatus').checked = this.dataset.status == 1;

            editModal.classList.remove('hidden');
        });
    });

    closeModal.addEventListener('click', () => editModal.classList.add('hidden'));

    // AJAX Update - FIXED URL
    editForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const groupId = document.getElementById('editGroupId').value;
        const formData = new FormData(editForm);
        
        // Add _method=PUT for Laravel
        formData.append('_method', 'PUT');

        fetch(`/admin/product-groups/${groupId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const row = document.getElementById(`group-${groupId}`);
                row.querySelector('.group-name').textContent = data.group.name;
                row.querySelector('.group-status').textContent = data.group.status ? 'Active' : 'Inactive';
                row.querySelector('.group-color').style.backgroundColor = data.group.colorHex;

                editModal.classList.add('hidden');

                const msg = document.getElementById('successMessage');
                msg.textContent = 'Product group updated successfully!';
                msg.classList.remove('hidden');
                setTimeout(() => msg.classList.add('hidden'), 3000);
            } else {
                alert('Update failed.');
            }
        })
        .catch(err => console.error(err));
    });



</script>
@endsection