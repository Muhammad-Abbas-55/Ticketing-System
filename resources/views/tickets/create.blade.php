<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ticket / Create
            </h2>
            <a href="{{ route('tickets.index') }}"
                class="bg-blue-600 hover:bg-blue-800 text-sm rounded-md py-2 px-3 text-white">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('tickets.store') }}" id="ticketForm" method="POST"
                        enctype="multipart/form-data"
                        class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-md space-y-6">
                        @csrf
                        <h2 class="text-2xl font-semibold text-gray-800">Create a Ticket</h2>
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" name="title" id="title" placeholder="Title"
                                value="{{ old('title') }}"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <span class="text-red-500 text-sm">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" placeholder="Description"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                            <span class="text-red-500 text-sm">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="open">Open</option>
                                    <option value="closed">Closed</option>
                                </select>
                            </div>

                            <div>
                                <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                                <select name="priority" id="priority" required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                        </div>


                        <div class="mt-4">
                            <label for="image" class="block text-sm font-medium text-gray-700">Attach Image</label>
                            <input type="file" name="image" id="image" class="filepond mt-1 block w-full"
                                accept="image/*">
                            <input type="hidden" name="uploaded_image_path" id="uploaded_image_path">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Labels</label>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach ($labels as $label)
                                    <label class="inline-flex items-center space-x-2">
                                        <input type="checkbox" name="labels[]" value="{{ $label->id }}"
                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                                            {{ in_array($label->id, old('labels', [])) ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-700">{{ $label->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Categories</label>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach ($categories as $category)
                                    <label class="inline-flex items-center space-x-2">
                                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                                            {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-700">{{ $category->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition duration-300">
                                Create Ticket
                            </button>
                        </div>

                    </form>
                    <div id="successMessage" class="hidden mt-4 text-green-600 font-semibold"></div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#ticketForm').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('tickets.store') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "OK",
                        confirmButtonColor: "#49984E"
                    });
                    $('#ticketForm')[0].reset();
                    pond.removeFiles(); // Reset FilePond images
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $('.text-red-500').text('');
                        $.each(errors, function(key, value) {
                            let input = $('[name="' + key + '"]');
                            input.closest('div').find('.text-red-500')
                                .text(value[0]);
                        });
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
    // Register the plugins
    FilePond.registerPlugin(
        FilePondPluginFileValidateType,
        FilePondPluginImagePreview
    );

    // Turn all file input elements into ponds
    const pond = FilePond.create(
        document.querySelector('input[type="file"]'), {
            acceptedFileTypes: ['image/*'],
            allowMultiple: false,
            instantUpload: true,
            server: {
                process: {
                    url: '{{ route('filepond.upload') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    onload: (response) => {
                        try {
                            const data = JSON.parse(response);
                            console.log(data.path);
                            $('#uploaded_image_path').val(data.path);
                            return data.path;
                        } catch (error) {
                            console.error('Failed to parse upload response', error);
                            return '';
                        }
                    },
                    onerror: (response) => {
                        console.error('Upload failed', response);
                        return 'Upload failed.';
                    }
                }
            }
        });
</script>
