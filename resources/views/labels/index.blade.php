<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                 Label
            </h2>
            @can('create labels')
                <a class="bg-blue-600 hover:bg-blue-800 text-sm rounded-md py-2 px-3 text-white"
                    href="{{ route('labels.create') }}">Create Label</a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            <div class="card">
                <div class="card-body">
                    <div class="overflow-x-auto">
                        <table id="cat-table" class="display table-blue">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
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
        $(document).ready(function() {
            $('#cat-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('labels.index') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'created_at', name: 'created_at' },
                    {
                        data: 'id',
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            var editUrl = '{{ route("labels.edit", ":id") }}'.replace(':id', data);
                            var deleteUrl = '{{ route("labels.destroy", ":id") }}'.replace(':id', data);
                            return `
                                <a href="${editUrl}" class="btn btn-sm btn-primary">Edit</a>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="${data}">Delete</button>
                            `;
                        }
                    }
                ]
            });
    
            // Delete button handler
            $('#cat-table').on('click', '.delete-btn', function() {
                var id = $(this).data('id');
                if (confirm('Are you sure you want to delete this label?')) {
                    $.ajax({
                        url: '{{ route("labels.destroy", ":id") }}'.replace(':id', id),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#cat-table').DataTable().ajax.reload();
                            alert('Labels deleted successfully.');
                        },
                        error: function(xhr) {
                            alert('An error occurred while deleting the labels.');
                        }
                    });
                }
            });
        });
    </script>

</x-app-layout>
