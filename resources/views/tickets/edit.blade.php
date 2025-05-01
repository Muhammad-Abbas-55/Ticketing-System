<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">
                Ticket / Create
            </h2>
            <a href="{{ route('tickets.index') }}"
                class="bg-blue-600 hover:bg-blue-800 text-white text-sm font-medium py-2 px-4 rounded-md transition">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md sm:rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900">

                    <form method="POST" id="ticket-form" action="{{ route('tickets.update', $ticket->id) }}"
                        enctype="multipart/form-data"
                        class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-md space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Title -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                <input type="text" name="title" value="{{ old('title', $ticket->title) }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                @error('title')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open
                                    </option>
                                    <option value="in_progress"
                                        {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed
                                    </option>
                                </select>
                            </div>

                            <!-- Priority -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                                <select name="priority"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="low" {{ $ticket->priority === 'low' ? 'selected' : '' }}>Low
                                    </option>
                                    <option value="medium" {{ $ticket->priority === 'medium' ? 'selected' : '' }}>Medium
                                    </option>
                                    <option value="high" {{ $ticket->priority === 'high' ? 'selected' : '' }}>High
                                    </option>
                                </select>
                            </div>

                            <!-- Image Upload -->
                            <!-- Image Upload -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Image (optional)</label>

                                <input type="file" name="image" id="image" class="filepond"
                                    data-allow-reorder="true" data-max-file-size="2MB" data-max-files="1" />
                                <input type="hidden" name="uploaded_image_path" id="uploaded_image_path">

                                @if ($ticket->image)
                                    <p class="mt-2 text-sm text-gray-500">
                                        Current:
                                        <a href="{{ asset('/' . $ticket->image) }}" target="_blank"
                                            class="text-blue-600 underline">View</a>
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" rows="4"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $ticket->description) }}</textarea>
                        </div>
                        @error('description')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                        <!-- Labels -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Labels</label>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach ($labels as $label)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="labels[]" value="{{ $label->id }}"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                            {{ in_array($label->id, old('labels', $ticket->labels->pluck('id')->toArray())) ? 'checked' : '' }}>
                                        <span class="text-gray-700 text-sm">{{ $label->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('labels')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>


                        <!-- Categories -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Categories</label>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach ($categories as $category)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                            {{ in_array($category->id, old('categories', $ticket->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                                        <span class="text-gray-700 text-sm">{{ $category->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('categories')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        @role('admin|super admin')
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Assign Agent</label>
                                <select name="agent_id"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">-- Select Agent --</option>
                                    @foreach ($agents as $agent)
                                        <option value="{{ $agent->id }}"
                                            {{ old('agent_id', $ticket->agent_id ?? '') == $agent->id ? 'selected' : '' }}>
                                            {{ $agent->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endrole

                        @role('admin|super admin|agent')
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Add Comment</label>
                                <textarea name="comment" rows="4"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('comment', $ticket->comment) }}</textarea>
                            </div>
                        @endrole

                        <!-- Buttons -->
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-800 text-white text-sm font-medium px-4 py-2 rounded-md transition">
                                Update
                            </button>
                            <a href="{{ route('tickets.index') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-sm text-black font-medium px-4 py-2 rounded-md transition">
                                Cancel
                            </a>
                        </div>
                    </form>


                    @role('admin|super admin')
                        <div class="mt-10">
                            <h3 class="text-lg font-semibold mb-4">Ticket Logs</h3>
                            <div class="bg-gray-100 p-4 rounded-md space-y-4 max-h-96 overflow-y-auto">
                                @forelse ($ticket->logs as $log)
                                    <div class="p-3 bg-white rounded shadow-sm">
                                        <p class="text-sm text-gray-700">
                                            <span class="font-medium">{{ $log->user->name }}</span>
                                            {{ $log->action }} the ticket
                                            <span
                                                class="text-gray-500 text-xs">({{ $log->created_at->diffForHumans() }})</span>
                                        </p>
                                        @if ($log->changes)
                                            <details class="mt-2 text-xs text-gray-600">
                                                <summary class="cursor-pointer">View Changes</summary>
                                                <pre class="bg-gray-50 p-2 rounded mt-1 overflow-x-auto">{{ json_encode(json_decode($log->changes), JSON_PRETTY_PRINT) }}</pre>
                                            </details>
                                        @endif
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500">No logs available for this ticket yet.</p>
                                @endforelse
                            </div>
                        </div>
                    @endrole


                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $("#ticket-form").on("submit", function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $(".text-red-500").text("");

            $.ajax({
                url: "{{ route('tickets.update', $ticket->id) }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Success!",
                            text: response.success,
                            icon: "success",
                            confirmButtonText: "OK",
                            confirmButtonColor: "#49984E"
                        });
                        // $("#ticket-form")[0].reset();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.name) $("#error-name").text(errors.name[0]);
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: "Something went wrong. Please try again.",
                            icon: "error",
                            confirmButtonText: "OK",
                            confirmButtonColor: "#DC3545"
                        });
                    }
                }
            });
        });
    });
</script>


<script>
    // Register plugins
    FilePond.registerPlugin(
        FilePondPluginImagePreview,
        FilePondPluginFileValidateType
    );

    // Turn all file input elements into ponds
    FilePond.create(document.querySelector('input[name="image"]'), {
    acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg'],
    labelIdle: `Drag & Drop your image or <span class="filepond--label-action">Browse</span>`,
    imagePreviewHeight: 140,
    server: {
        process: {
            url: "{{ route('filepond.upload') }}",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            onload: (response) => {
                let res = JSON.parse(response);
                document.getElementById('uploaded_image_path').value = res.path;
            },
        },
        revert: null,
    },
});

</script>
