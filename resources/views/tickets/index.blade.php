<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tickets</h2>
            @can('create tickets')
                <a href="{{ route('tickets.create') }}"
                    class="bg-blue-600 hover:bg-blue-800 text-white text-sm rounded-md py-2 px-4">
                    Create Ticket </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message />
            <div class="bg-white shadow-md rounded p-4">
                <div class="overflow-x-auto">
                    <table id="tickets-table" class="min-w-full table-auto">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Labels</th>
                                <th>Categories</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const table = $('#tickets-table').DataTable({
                processing: true,
                responsive: true,   
                serverSide: true,
                ajax: '{{ route('tickets.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'user',
                        name: 'user.name'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'priority',
                        name: 'priority'
                    },
                    {
                        data: 'labels',
                        name: 'labels',
                        orderable: false, // ← disable ordering
                        searchable: false
                    },
                    {
                        data: 'categories',
                        name: 'categories',
                        orderable: false, // ← disable ordering
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(id) {
                            const editUrl = `{{ route('tickets.edit', ':id') }}`.replace(':id', id);
                            const showUrl = `{{ route('tickets.show', ':id') }}`.replace(':id', id);
                            return `
                            @can('edit tickets')
                                <a href="${editUrl}" class="px-3 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded text-xs mr-1">
                                    Edit
                                </a>
                            @endcan
                            @can('delete tickets')
                                <button data-id="${id}" class="delete-btn mb-1 px-3 py-2 bg-red-500 hover:bg-red-700 text-white rounded text-xs">
                                    Delete
                                </button>
                            @endcan
                            @can('show tickets')
                                <a href="${showUrl}" class="px-3 py-2 bg-green-500 hover:bg-green-700 text-white rounded text-xs">
                                    Show
                                </a>
                            @endcan
                            `;
                        }
                    }
                ]
            });

            // Delete ticket
            $('#tickets-table').on('click', '.delete-btn', function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This will delete the ticket permanently.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    confirmButtonColor: '#e3342f'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/tickets/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function() {
                                Swal.fire('Deleted!', 'Ticket has been deleted.',
                                    'success');
                                $('#tickets-table').DataTable().ajax.reload();
                            },
                            error: function() {
                                Swal.fire('Error!', 'Unable to delete the ticket.',
                                    'error');
                            }
                        });
                    }
                });
            });

        });
    </script>
</x-app-layout>
