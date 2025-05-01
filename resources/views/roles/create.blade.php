<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Role / Create
            </h2>
            <a href="{{ route('roles.index') }}"
                class="bg-blue-600 hover:bg-blue-800 text-sm rounded-md py-2 px-3 text-white">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form id="role-form" action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700">Name</label>
                                <input type="text" name="name" id="name" placeholder="Enter role name"
                                    value="{{ old('name') }}"
                                    class="w-full border-b mt-1 focus:ring-0 focus:outline-none focus:border-green-500">
                                <span class="text-red-500 text-sm" id="error-name"></span>
                            </div>
                        </div>

                        <p class="mt-3">Add Permissions</p>
                        <div class="grid grid-cols-4">
                            @if ($permissions->isNotEmpty())
                                @foreach ($permissions as $permission)
                                    <div class="mt-3">
                                        <input type="checkbox" class="rounded" id="permission.{{ $permission->id }}"
                                            name="permission[]" value="{{ $permission->name }}">
                                        <label for="permission.{{ $permission->id }}">{{ $permission->name }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="flex mt-6">
                            <button class="bg-blue-600 hover:bg-blue-800 text-sm rounded-md py-2 px-4 text-white">Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $("#role-form").on("submit", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $(".text-red-500").text("");

                $.ajax({
                    url: "{{ route('roles.store') }}",
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
                            $("#role-form")[0].reset();
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

</x-app-layout>
