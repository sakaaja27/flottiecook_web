@extends('livewire.pages.components.main')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-account"></i>
            </span> Edit recipe
        </h3>
    </div>

    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('recipt.index') }}"
                        class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path
                                d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
                        </svg>
                        Back
                    </a>

                    <form id="editReciptForm" method="POST" action="{{ route('recipt.update', $recipt->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3 row">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" id="name" name="name" value="{{ $recipt->name }}" required
                                    class="form-control" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="description" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <input type="text" id="description" name="description" value="{{ $recipt->description }}" required
                                    class="form-control" />
                            </div>
                        </div>

                        {{-- <div class="mb-3 row">
                            <label for="image_path" class="col-sm-2 col-form-label">Upload Images</label>
                            <div class="col-sm-10">
                                <input type="file" id="image_path" name="image_path[]" multiple class="form-control" />
                                <small class="form-text text-muted">Upload multiple images if needed.</small>
                            </div>
                        </div> --}}

                        {{-- Tampilkan gambar lama --}}
                        {{-- @if($recipt->images && $recipt->images->count())
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Current Images</label>
                            <div class="col-sm-10 d-flex flex-wrap gap-2">
                                @foreach ($recipt->images as $image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}" width="100" class="img-thumbnail" />
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($recipt->images && $recipt->images->count())
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Current Images</label>
                            <div class="col-sm-10 d-flex flex-wrap gap-2">
                                @foreach ($recipt->images as $image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}" width="100" class="img-thumbnail" />
                                @endforeach
                            </div>
                        </div>
                        @endif
                        @if($recipt->images && $recipt->images->count())
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Current Images</label>
                            <div class="col-sm-10 d-flex flex-wrap gap-2">
                                @foreach ($recipt->images as $image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}" width="100" class="img-thumbnail" />
                                @endforeach
                            </div>
                        </div>
                        @endif --}}

                        <div class="mb-3 row">
                            <label for="image_path" class="col-sm-2 col-form-label">Gambar</label>
                            <div class="col-sm-10">
                                {{-- Tampilkan gambar lama jika ada --}}
                                @if($recipt->images && $recipt->images->count())
                                    <img src="{{ asset('storage/' . $recipt->images->first()->image_path) }}"
                                         alt="Image Recipe"
                                         id="oldImage"
                                         class="img-fluid mb-3"
                                         style="max-width: 200px; max-height: 200px;">
                                @endif

                                {{-- Tempat preview gambar baru --}}
                                <img src="" id="showImage" class="img-fluid mt-3 mb-4"
                                     style="max-width: 200px; max-height: 200px; display: none;">

                                <input type="file" class="form-control" name="image_path[]" id="image_path" accept="image/*" multiple>
                            </div>
                        </div>



                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit"
                                class="btn btn-primary">
                                SAVE
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#editReciptForm').on('submit', function(e) {
            e.preventDefault();

            let form = $(this)[0];
            let formData = new FormData(form);

            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = response.redirect;
                        }
                    });
                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi kesalahan.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = '';
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            errorMessage += value[0] + '\n';
                        });
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>
@endpush
