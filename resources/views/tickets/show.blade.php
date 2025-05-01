<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ticket Details: {{ $ticket->title }}
            </h2>
            <a href="{{ route('tickets.index') }}"
                class="bg-blue-600 hover:bg-blue-800 text-sm rounded-md py-2 px-4 text-white">
                Back to Tickets
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Main Ticket Card -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-6">
                    <!-- Ticket Header -->
                    <div class="flex justify-between items-center border-b pb-4 mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Ticket Information</h3>
                        </div>
                    </div>

                    <!-- Ticket Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Ticket Title and Description -->
                        <div class="space-y-4">
                            <div>
                                <p class="text-lg font-semibold text-gray-700"><strong>Title:</strong></p>
                                <p class="text-gray-900">{{ $ticket->title }}</p>
                            </div>

                            <div>
                                <p class="text-lg font-semibold text-gray-700"><strong>Description:</strong></p>
                                <p class="text-gray-900">{{ $ticket->description }}</p>
                            </div>
                        </div>

                        <!-- Ticket Status and Priority -->
                        <div class="space-y-4">
                            <div>
                                <p class="text-lg font-semibold text-gray-700"><strong>Status:</strong></p>
                                <p class="font-medium text-blue-500">{{ ucfirst($ticket->status) }}</p>
                            </div>

                            <div>
                                <p class="text-lg font-semibold text-gray-700"><strong>Priority:</strong></p>
                                <p class="font-medium text-green-500">{{ ucfirst($ticket->priority) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Ticket User & Dates -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-lg font-semibold text-gray-700"><strong>Assigned User:</strong></p>
                            <p class="text-gray-900">{{ $ticket->user->name ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-lg font-semibold text-gray-700"><strong>Created At:</strong></p>
                            <p class="text-gray-900">{{ $ticket->created_at->format('d M Y') }}</p>
                        </div>
                    </div>

                    <!-- Labels and Categories -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-lg font-semibold text-gray-700"><strong>Labels:</strong></p>
                            <ul class="list-disc ml-6 space-y-2">
                                @foreach ($ticket->labels as $label)
                                    <li class="text-gray-900">{{ $label->name }}</li>
                                @endforeach
                            </ul>
                        </div>

                        <div>
                            <p class="text-lg font-semibold text-gray-700"><strong>Categories:</strong></p>
                            <ul class="list-disc ml-6 space-y-2">
                                @foreach ($ticket->categories as $category)
                                    <li class="text-gray-900">{{ $category->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Ticket User, Agent & Dates -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-lg font-semibold text-gray-700"><strong>Ticket Create:</strong></p>
                            <p class="text-gray-900">{{ $ticket->user->name ?? 'N/A' }}</p>
                        </div>

                        <div>
                            <p class="text-lg font-semibold text-gray-700"><strong>Assigned Agent:</strong></p>
                            <p class="text-gray-900">{{ $ticket->agent ? $ticket->agent->name : 'Not Assigned' }}</p>
                        </div>
                    </div>

                    <!-- Ticket Comment -->
                    @if ($ticket->comment)
                        <div class="mt-8">
                            <p class="text-lg font-semibold text-gray-700"><strong>Comment:</strong></p>
                            <p class="text-gray-900 mt-2">{{ $ticket->comment }}</p>
                        </div>
                    @endif

                    <!-- Image Section -->
                    @if ($ticket->image)
                        <div class="mb-6">
                            <p class="text-lg font-semibold text-gray-700"><strong>Ticket Image:</strong></p>
                            @if ($ticket->image)
                                <a href="{{ asset($ticket->image) }}" target="_blank">
                                    <img src="{{ asset($ticket->image) }}" alt="Ticket Image"
                                        class="w-60 h-auto mt-2 rounded shadow cursor-pointer hover:opacity-80 transition">
                                </a>
                            @endif
                        </div>
                    @endif

                    <!-- Ticket Actions -->
                    <div class="flex justify-end mt-6 space-x-4">
                        @can('edit tickets')
                            <a href="{{ route('tickets.edit', $ticket) }}"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-md">
                                Edit Ticket
                            </a>
                        @endcan
                        @can('delete tickets')
                            <button class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md" id="delete-ticket"
                                data-id="{{ $ticket->id }}">
                                Delete Ticket
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('delete-ticket')?.addEventListener('click', function() {
            const ticketId = this.getAttribute('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will delete the ticket permanently.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                confirmButtonColor: '#e3342f'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/tickets/${ticketId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                    }).then(response => {
                        if (response.ok) {
                            Swal.fire('Deleted!', 'The ticket has been deleted.', 'success').then(
                                () => {
                                    window.location.href = '{{ route('tickets.index') }}';
                                });
                        } else {
                            Swal.fire('Error!', 'Unable to delete the ticket.', 'error');
                        }
                    });
                }
            });
        });
    </script>
</x-app-layout>
