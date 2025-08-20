<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Student List</title>

    <style>
        .std_table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .std_table thead {
            background-color: #2563eb;
            /* Blue header */
            color: #fff;
            text-align: left;
        }

        .std_table th,
        .std_table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e5e7eb;
        }

        .std_table tbody tr:nth-child(even) {
            background-color: #f9fafb;
            /* Zebra striping */
        }

        .std_table tbody tr:hover {
            background-color: #eef2ff;
            /* Hover effect */
        }

        .std_table th {
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
        }

        /* Responsive (scroll on mobile) */
        .table-wrapper {
            overflow-x: auto;
        }

        /* Optional: Action buttons */
        .action-btn {
            padding: 6px 10px;
            margin-right: 4px;
            font-size: 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
        }

        .action-btn.edit {
            background: #3b82f6;
            color: #fff;
        }

        .action-btn.delete {
            background: #ef4444;
            color: #fff;
        }

        .action-btn.view {
            background: #10b981;
            color: #fff;
        }
    </style>
</head>

<body>


    <div class="py-12 table-wrapper" id="stdContainer">
    </div>


    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            function studentList() {
                $.ajax({
                    url: "/students",
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        // console.log(response.data);

                        let stdData = `
                        <table id="std_table" class="std_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Father Name</th>
                                    <th>Gender</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;

                        if (response.data && response.data.length > 0) {
                            // response.data.forEach((std, index) => {    // or
                            $.each(response.data, function(index, std) {
                                stdData += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${std.name ?? ""}</td>
                                    <td>${std.f_name ?? ""}</td>
                                    <td>${std.gender ?? ""}</td>
                                    <td>
                                        ${std.image 
                                            ? `<img src="${std.image}" alt="${std.name}" width="50" height="50" style="border-radius:6px;object-fit:cover;">` 
                                            : `-`}
                                    </td>
                                    <td>
                                        <button class="action-btn view" data-id="${std.id}">View</button>
                                        <button class="action-btn edit" data-id="${std.id}">Edit</button>
                                        <button class="action-btn delete" data-id="${std.id}">Delete</button>
                                    </td>
                                </tr>
                            `;
                            });
                        } else {
                            stdData += `
                            <tr>
                                <td colspan="6" style="text-align:center;">No students found</td>
                            </tr>
                        `;
                        }

                        stdData += `
                            </tbody>
                        </table>
                    `;

                        $("#stdContainer").html(stdData);
                    },
                    error: function(xhr) {
                        $("#stdContainer").html(
                            `<div class="alert alert-danger">Error loading students (status ${xhr.status})</div>`
                        );
                    }
                });
            }

            studentList();
        });
    </script>




</body>

</html>
