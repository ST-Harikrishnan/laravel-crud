<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Blog Site')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
    body {
        min-height: 100vh;
        display: flex;
    }

    .sidebar {
        width: 240px;
        min-height: 100vh;
    }

    .content {
        flex: 1;
        padding: 2rem;
    }
    </style>
</head>

<body class="bg-light">

    @include('layouts.header')

    <main class="container py-4">
        @yield('content')
    </main>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function toggleTheme() {
        const html = document.documentElement;
        const current = html.getAttribute("data-bs-theme");
        html.setAttribute("data-bs-theme", current === "dark" ? "light" : "dark");
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-confirm-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                const form = this.closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to undo this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Only if jQuery isn't already included -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();

    });
    </script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
    $(document).ready(function() {
        let table = $('#user-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('admin.users.data') }}',
                data: function(d) {
                    d.role = $('#roleFilter').val();
                }
            },
             language: {
            search: "_INPUT_",
            searchPlaceholder: "🔍 Search users...",
            lengthMenu: "Show _MENU_ entries",
            paginate: {
                previous: "<<  Prev",
                next: "Next >>"
            },
            info: "Showing _START_ to _END_ of _TOTAL_ users"
        },
        dom: '<"d-flex justify-content-between align-items-center m-3"lf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'role',
                    name: 'role',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#roleFilter').change(function() {
            table.draw();
        });
    });
    </script>

</body>

</html>