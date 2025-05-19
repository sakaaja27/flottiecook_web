@extends('livewire.pages.components.main')
@section('title', 'Recipes Category Management')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-food"></i>
                </span> Manajemen Recipe Category
            </h3>
        </div>

        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('recipe.category.create') }}" class="btn btn-success mb-3"> + Add Category</a>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="category-table">
                                <thead>
                                    <tr>
                                        <th>Number</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = "{{ route('recipe.category.index') }}";
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
                confirmButtonText: 'Coba Lagi'
            });
        @endif
    </script>
    <script>
        $(function() {

            $('#category-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('recipe.category.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'

                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [0, 'desc']
                ],
                columnDefs: [{
                    targets: 0,
                    orderable: false,
                    searchable: false
                }]
            });
        });
        $(document).on('click', '.delete_category', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = "{{ route('recipe.category.destroy', ':id') }}".replace(':id', id);

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.status) {
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    $('#category-table').DataTable().ajax.reload();
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'Failed to delete category.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    </script>
@endpush
