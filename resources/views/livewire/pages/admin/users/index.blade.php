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
@endsection

@push('scripts')
<script>
    $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });

        $('body').on('click', '.delete', function (_id,_name) {
            var user_id = $(this).data("id");
            var user_name = $(this).data("name");
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('user.destroy','') }}/" + user_id,
                        success: function (data) {
                            table.draw();
                            Swal.fire(
                                'Terhapus!',
                                'User telah dihapus.',
                                'success'
                            )
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
            })
        });

        $('body').on('click','.reset', function (_id,_name) {
            var user_id = $(this).data("id");
            var user_name = $(this).data("name");
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda tidak akan dapat mengembalikan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, reset!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('user.reset', '') }}/" + user_id,
                        success: function (data) {
                            table.draw();
                            Swal.fire(
                                'Berhasil!',
                                'Password telah direset.',
                                'success'
                            )
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
            })
        });
    });
</script>
@endpush
