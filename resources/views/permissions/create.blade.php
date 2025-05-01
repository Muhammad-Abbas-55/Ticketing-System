

<x-app-layout>
    <x-slot name="header">
      <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Permission / Create
        </h2>
        <a href="{{ route('permissions.index') }}"
           class="bg-blue-600 hover:bg-blue-800 text-sm rounded-md py-2 px-3 text-white">
          Back
        </a>
      </div>
    </x-slot>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <form id="permission-form" action="{{ route('permissions.store') }}" method="POST">
              @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700">Name</label>
                        <input type="text" name="name" id="name" placeholder="Enter permission name"
                            value="{{ old('name') }}"
                            class="w-full border-b mt-1 focus:ring-0 focus:outline-none focus:border-green-500">
                        <span class="text-red-500 text-sm" id="error-name"></span>
                    </div>
                </div>
        
                <div class="flex mt-6">
                    <button class="bg-blue-600 hover:bg-blue-800 text-sm rounded-md py-2 px-4 text-white">Submit</button>
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
            $("#permission-form").on("submit", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $(".text-red-500").text("");
    
                $.ajax({
                    url: "{{ route('permissions.store') }}",
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
                            $("#permission-form")[0].reset();
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
  

  {{-- <x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Permissions
            </h2>
            <a class="bg-blue-600 text-sm rounded-md py-2 px-3 text-white" 
            href="{{ route('permissions.index') }}">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{route('permissions.store')}}" method="post">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input name="name" value="{{old('name')}}" type="text" placeholder="Enter Permission Name" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('name')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <button class="bg-blue-600 text-sm rounded-md py-3 px-5 text-white">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}