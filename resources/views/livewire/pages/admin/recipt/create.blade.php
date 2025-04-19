@extends('livewire.pages.components.main')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-food"></i>
            </span> Add Recipe
        </h3>
    </div>

    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('recipt.index') }}" class="text-indigo-600 font-medium mb-6 d-inline-block">
                        <i class="mdi mdi-arrow-left"></i> Back
                    </a>

                    <form id="recipes" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    placeholder="Enter Food Name" />
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="category_id" class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">
                                <select name="category_id" id="category_id" required
                                    class="form-control text-gray-500"
                                    onchange="this.classList.remove('text-gray-500'); this.classList.add('text-black');">
                                    <option value="" selected disabled>-- Pilih Kategori --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="mb-3 row">
                            <label for="description" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea id="description" name="description" rows="5" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Describe your food..."></textarea>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="tools" class="col-sm-2 col-form-label">Tools</label>
                            <div class="col-sm-10">
                                <textarea id="tools" name="tools" rows="5" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Add tools"></textarea>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="ingredient" class="col-sm-2 col-form-label">Ingredients</label>
                            <div class="col-sm-10">
                                <textarea id="ingredient" name="ingredient" rows="5" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Add ingredients"></textarea>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="instruction" class="col-sm-2 col-form-label">Instruction</label>
                            <div class="col-sm-10">
                                <textarea id="instruction" name="instruction" rows="5" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Add cooking step""></textarea>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10" id="file-container">
                                <div class="input-group mb-2">
                                    <input type="file" name="image_path[]" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                                    <button type="button" class="btn btn-success add-btn">
                                        <i class="mdi mdi-plus-box"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">SAVE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- SweetAlert2 -->
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
                    <input type="file" name="image_path[]" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
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
    });

    $(document).ready(function () {
        $('#recipes').on('submit', function (e) {
            e.preventDefault();
            console.log('Form submitted');
            $.ajax({
                url: "{{ route('recipt.store') }}",
                method: "POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = response.redirect;
                    });
                },
                error: function (xhr) {
                    let errorMessage = 'Terjadi kesalahan.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).join('\n');
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMessage,
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>
@endpush
