<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User / Edit
            </h2>
            <a href="{{ route('users.index') }}"
                class="bg-blue-600 hover:bg-blue-800 text-sm rounded-md py-2 px-3 text-white">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form id="user-form" action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700">Name</label>
                                <input type="text" name="name" id="name" placeholder="Enter user name"
                                    value="{{ old('name', $user->name) }}"
                                    class="w-full border-b mt-1 focus:ring-0 focus:outline-none focus:border-green-500">
                                <span class="text-red-500 text-sm" id="error-name"></span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700">Email</label>
                                <input type="text" name="email" id="email" placeholder="Enter user email"
                                    value="{{ old('email', $user->email) }}"
                                    class="w-full border-b mt-1 focus:ring-0 focus:outline-none focus:border-green-500">
                                <span class="text-red-500 text-sm" id="error-email"></span>
                            </div>
                        </div>

                        <p class="mt-3">Assign Role</p>
                        <div class="grid grid-cols-1 md:grid-cols-1 justify-between">
                            <div class="grid grid-cols-4">
                                @if ($roles->isNotEmpty())
                                    @foreach ($roles as $role)
                                        <div class="mt-3">
                                            <input {{ $hasRoles->contains($role->id) ? 'checked' : '' }} 
                                                type="checkbox" class="rounded" id="role.{{ $role->id }}"
                                                name="role[]" value="{{ $role->name }}">
                                            <label
                                                for="role.{{ $role->id }}">{{ $role->name }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="flex mt-6">
                            <button
                                class="bg-blue-600 hover:bg-blue-800 text-sm rounded-md py-2 px-4 text-white">Update</button>
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
            $("#user-form").on("submit", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $(".text-red-500").text("");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('users.update', $user->id) }}",
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
                            // $("#user-form")[0].reset();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.name) $("#error-name").text(errors.name[0]);
                            if (errors.email) $("#error-email").text(errors.email[0]);
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
