@extends('livewire.pages.components.main')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-account"></i>
            </span> Edit Recipe
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
                    {{-- pakai enctype karena ada up image --}}
                    <form id="editReciptForm" method="POST" action="{{ route('recipt.update', $recipt->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3 row">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" id="name" name="name" value="{{ $recipt->name }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="category_id" class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">

                                <select name="category_id" id="category_id" required
                                class="form-control {{ old('category_id', $recipt->category_id) ? 'text-black' : 'text-gray-500' }}"
                                onchange="this.classList.remove('text-gray-500'); this.classList.add('text-black');">
                                <option value="" disabled {{ !$recipt->category_id ? 'selected' : '' }}>-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $recipt->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="description" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <input type="text" id="description" name="description" value="{{ $recipt->description }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="tools" class="col-sm-2 col-form-label">Tools</label>
                            <div class="col-sm-10">
                                <input type="text" id="tools" name="tools" value="{{ $recipt->tools }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="ingredient" class="col-sm-2 col-form-label">Ingredients</label>
                            <div class="col-sm-10">
                                <input type="text" id="ingredient" name="ingredient" value="{{ $recipt->ingredient }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="instruction" class="col-sm-2 col-form-label">Instructions</label>
                            <div class="col-sm-10">
                                <input type="text" id="instruction" name="instruction" value="{{ $recipt->instruction }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="image_path" class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10" id="file-container">


                             {{-- menampilkan Gambar lama --}}
                        @if($recipt->images && $recipt->images->count())
                        <label class="form-label"></label>
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach ($recipt->images as $image)
                                <div class="position-relative me-2">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" width="100" class="img-thumbnail">
                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 delete-image-btn"
                                        data-id="{{ $image->id }}" title="Delete Image">
                                        &times;
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        @endif


                                {{-- Preview gambar baru --}}
                                <img src="" id="showImage" class="img-fluid mt-3 mb-3 d-none" style="max-width: 200px; max-height: 200px;">
                                {{-- Upload gambar baru --}}
                                <div class="input-group mb-2">
                                    <input type="file" class=" px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" name="image_path[]" id="image_path" accept="image/*" multiple>
                                    <button type="button" class="btn btn-success add-btn">
                                        <i class="mdi mdi-plus-box"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-primary">
                                    SAVE
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Hapus gambar
        document.querySelectorAll(".delete-image-btn").forEach(button => {
            button.addEventListener("click", function () {
                const imageId = this.dataset.id;

                Swal.fire({
                    title: 'Hapus Gambar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/recipt/image/${imageId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            },
                        })
                        .then(res => res.json())
                        .then(data => {
                            Swal.fire('Berhasil!', data.message, 'success')
                                .then(() => location.reload());
                        })
                        .catch(() => {
                            Swal.fire('Error', 'Gagal menghapus gambar.', 'error');
                        });
                    }
                });
            });
        });

        // gambar max 3
        const container = document.getElementById("file-container");

        container.addEventListener("click", function (e) {
            if (e.target.closest(".add-btn")) {
                const existing = {{ $recipt->images->count() }};
                const newFiles = container.querySelectorAll('input[type="file"]').length;

                if (existing + newFiles >= 3) {
                    Swal.fire('Maksimal 3 Gambar', 'Gambar tidak boleh lebih dari 3', 'warning');
                    return;
                }

                const newInput = document.createElement("div");
                newInput.className = "input-group mb-2";
                newInput.innerHTML = `
                    <input type="file" name="image_path[]" class=" px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    <button type="button" class="btn btn-danger remove-btn">
                        <i class="mdi mdi-close-box"></i>
                    </button>`;
                container.appendChild(newInput);
            }

            if (e.target.closest(".remove-btn")) {
                e.target.closest(".input-group").remove();
            }
        });

        // Preview gambar
        document.getElementById("image_path").addEventListener("change", function (event) {
            const showImage = document.getElementById("showImage");
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    showImage.src = e.target.result;
                    showImage.classList.remove("d-none");
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const container = document.getElementById("file-container");

        container.addEventListener("click", function (e) {
            if (e.target.closest(".add-btn")) {
                const fileInputs = container.querySelectorAll('input[type="file"]');
                if (fileInputs.length >= 3) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Maksimal 3 Gambar',
                        text: 'Kamu hanya bisa menambahkan maksimal 3 gambar.',
                        confirmButtonColor: '#3085d6',
                    });
                    return;
                }

                const newInput = document.createElement("div");
                newInput.className = "input-group mb-2";

                newInput.innerHTML = `
                    <input type="file" name="image_path[]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    <button type="button" class="btn btn-danger remove-btn">
                        <i class="mdi mdi-close-box"></i>
                    </button>
                `;
                container.appendChild(newInput);
            }

            if (e.target.closest(".remove-btn")) {
                e.target.closest(".input-group").remove();
            }
        });

        // Preview gambar
        document.getElementById("image_path").addEventListener("change", function (event) {
            const showImage = document.getElementById("showImage");
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    showImage.src = e.target.result;
                    showImage.classList.remove("d-none");
                };
                reader.readAsDataURL(file);
            }
        });

        // kirim AJAX
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
