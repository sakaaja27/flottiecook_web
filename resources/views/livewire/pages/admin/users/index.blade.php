
@extends('livewire.pages.components.main')
@section('title', 'User Management')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-account"></i>
                </span> Manajemen User
            </h3>
        </div>

        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        {{-- <button class="btn btn-success mb-2 create-new">+ Tambah User</button> --}}
                        {{-- <button class="btn btn-success mb-3 create-new"  href="{{ route('users.create') }}">+ Tambah User</button> --}}
                        <a href="{{ route('users.create') }}" class="btn btn-success mb-3">+ Tambah User</a>


                        <div class="table-responsive">
                            <table class="table table-bordered" id="users-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="ajaxModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading"></h4>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="userForm" name="userForm">
                        @csrf
                        <input type="hidden" name="user_id" id="user_id">
                        <div class="form-group">
                            <label for="name">Nama:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2" id="saveBtn">Simpan</button>
                    </form>
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

            var table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
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
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('.create-new').click(function() {
                $('#saveBtn').val("create-user");
                $('#user_id').val('');
                $('#userForm').trigger("reset");
                $('#modalHeading').html("Tambah User");
                $('#ajaxModal').modal('show');
            });

            $('body').on('click', '.edit', function() {
                var user_id = $(this).data('id');
                $.get("{{ route('users.index') }}/" + user_id + "/edit", function(data) {
                    $('#modalHeading').html("Edit User");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModal').modal('show');
                    $('#user_id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                });
            });

            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $(this).html('Menyimpan...');

                var user_id = $('#user_id').val();
                var url = user_id ? "{{ url('/users') }}/" + user_id : "{{ route('users.store') }}";
                var method = user_id ? "PUT" : "POST";

                $.ajax({
                    data: $('#userForm').serialize(),
                    url: url,
                    type: method,
                    dataType: 'json',
                    success: function(data) {
                        $('#userForm').trigger("reset");
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

            $('body').on('click', '.delete', function() {
                var user_id = $(this).data("id");
                if (confirm("Yakin ingin menghapus?")) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('/users') }}/" + user_id,
                        success: function(data) {
                            table.draw();
                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                }
            });
        });
    </script>
@endpush
