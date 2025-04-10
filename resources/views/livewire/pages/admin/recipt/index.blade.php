    @extends('livewire.pages.components.main')
    @section('title', 'User Management')
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
                                        {{-- <th>Photo</th> --}}
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

    <!-- Modal -->
    {{-- <div class="modal fade" id="ajaxModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalHeading"></h4>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="reciptForm" name="reciptForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="recipt_id" id="recipt_id">
                        <input type="hidden" name="_method" id="form_method" value="POST">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <input type="text" class="form-control" id="description" name="description" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="photo">Photo:</label>
                            <input type="file" class="form-control" id="photo" name="image_path[]" multiple required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2" id="saveBtn">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    @endsection

    @push('scripts')
    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#recipt-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('recipt.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    { data: 'status', name: 'status' },
                    // { data: 'photo', name: 'photo', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            $('#saveBtn').click(function (e) {
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
                    success: function (data) {
                        $('#reciptForm').trigger("reset");
                        $('#ajaxModal').modal('hide');
                        table.draw();
                        $('#saveBtn').html('Simpan');
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Simpan');
                    }
                });
            });

            $('body').on('click', '.edit', function () {
                var recipt_id = $(this).data('id');
                var url = "{{ route('recipt.edit', ':id') }}".replace(':id', recipt_id);

                $.get(url, function (data) {
                    $('#modalHeading').html("Edit Recipt");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModal').modal('show');
                    $('#recipt_id').val(data.id);
                    $('#name').val(data.name);
                    $('#description').val(data.description);
                    $('#status').val(data.status);
                });
            });

            $('body').on('click', '.delete', function () {
                var recipt_id = $(this).data("id");
                if (confirm("Yakin ingin menghapus?")) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('/recipt') }}/" + recipt_id,
                        success: function (data) {
                            table.draw();
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                }
            });
        });
    </script>
    @endpush
