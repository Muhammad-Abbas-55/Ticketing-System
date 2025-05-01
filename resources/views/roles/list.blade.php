<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles
            </h2>
            @can('create roles')
                <a class="bg-blue-600 hover:bg-blue-800 text-sm rounded-md py-2 px-3 text-white"
                    href="{{ route('roles.create') }}">Create Role</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            <div class="card">
                <div class="card-body">
                    <div class="overflow-x-auto">
                        <table id="roles-table" class="display table-blue ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Permissions</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function() {
            // CSRF header
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // 1. Initialize and store the DataTable instance
            const table = $('#roles-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('roles.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'permissions',
                        name: 'permissions',
                        orderable: false, // ← disable ordering
                        searchable: false // ← disable searching
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
                            const editUrl = `{{ route('roles.edit', ':id') }}`.replace(':id', id);
                            return `
                            <div class="flex flex-wrap gap-1">
                            @can('edit roles')
                                <a href="${editUrl}" class="px-3 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded text-xs mr-1">
                                    Edit
                                </a>
                            @endcan
                            @can('delete roles')
                                <button data-id="${id}" class="delete-btn px-3 py-2 bg-red-500 hover:bg-red-700 text-white rounded text-xs">
                                    Delete
                                </button>
                            @endcan
                            </div>`;
                        }
                    }
                ]
            });



            // 2. Attach delete handler separately, using the stored `table`
            $('#roles-table').on('click', '.delete-btn', function() {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Confirm Delete?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    confirmButtonColor: '#e3342f'
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    $.ajax({
                        url: `{{ route('roles.destroy', ':id') }}`.replace(':id', id),
                        type: 'DELETE',
                        success: function() {
                            Swal.fire('Deleted!', 'Role has been deleted.', 'success');
                            table.ajax.reload(null, false); // refresh DataTable
                        },
                        error: function() {
                            Swal.fire('Error!', 'Could not delete role.', 'error');
                        }
                    });
                });
            });
        });
    </script>

</x-app-layout>
