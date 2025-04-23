    @extends('livewire.pages.components.main')
    @section('title', 'Recipes Management')
    @section('content')
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white me-2">
                        <i class="mdi mdi-food"></i>
                    </span> Manajemen Recipe
                </h3>
            </div>

            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <ul class="nav nav-pills m-3" id="recipe-status-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-status="all" type="button">All Recipes</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-status="pending" type="button">Recipes Pending</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-status="accept" type="button">Recipes Accepted</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-status="reject" type="button">Recipes Rejected</button>
                            </li>
                        </ul>
                        <div class="card-body">

                            <a href="{{ route('recipt.create') }}" class="btn btn-success mb-3">+ Add recipe</a>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="recipt-table">
                                    <thead>
                                        <tr>
                                            <th>Number</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Status</th>

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
        <script>
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var statusFilter = 'all';

                var table = $('#recipt-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('recipt.index') }}",
                        data: function(d) {
                            d.status = statusFilter;
                        }
                    },
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
                            data: 'description',
                            name: 'description'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

                $('#recipe-status-tab .nav-link').on('click', function() {
                    $('#recipe-status-tab .nav-link').removeClass('active');
                    $(this).addClass('active');
                    statusFilter = $(this).data('status');
                    table.ajax.reload();
                });


                $('#saveBtn').click(function(e) {
                    e.preventDefault();
                    $(this).html('Menyimpan...');

                    let formData = new FormData($('#reciptForm')[0]);
                    let recipt_id = $('#recipt_id').val();
                    let url = '';

                    if (recipt_id) {
                        url = "{{ route('recipt.update', ':id') }}".replace(':id', recipt_id);
                        formData.append('_method', 'PUT');
                    } else {
                        url = "{{ route('recipt.store') }}";
                    }

                    $.ajax({
                        data: formData,
                        url: url,
                        type: "POST",
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            $('#reciptForm').trigger("reset");
                            $('#ajaxModal').modal('hide');
                            table.draw();
                            $('#saveBtn').html('Simpan');
                        },
                        error: function(data) {
                            console.log('Error:', data);
                            $('#saveBtn').html('Simpan');
                        }
                    });
                });


                $(document).on('click', '.delete', function(e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    var url = "{{ route('recipt.delete', ':id') }}".replace(':id', id);

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
                                    if (response.success) {
                                        Swal.fire(
                                            'Deleted!',
                                            response.message,
                                            'success'
                                        ).then(() => {
                                            $('#recipt-table').DataTable().ajax
                                                .reload();
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    Swal.fire(
                                        'Error!',
                                        'Failed to delete recipe.',
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                });


            });
        </script>
    @endpush
