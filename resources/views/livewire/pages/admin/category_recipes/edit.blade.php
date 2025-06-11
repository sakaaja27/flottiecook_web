@extends('livewire.pages.components.main')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-account"></i>
                </span> Edit Recipe Category
            </h3>
        </div>

        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('recipe.category.index') }}"
                            class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
                            </svg>
                            Back
                        </a>
                        <form id="category" method="POST" action="{{ route('recipe.category.update', $category->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3 row">
                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" id="name" name="name" value="{{ $category->name }}"
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="image" class="col-sm-2 col-form-label">Image</label>
                                <div class="col-sm-10">
                                    <div id="image-preview-container">
                                        @if ($category->image)
                                            <div id="current-image">
                                                <img src="{{ asset('storage/recipes_category' . $category->image) }}"
                                                    alt="{{ $category->name }}"
                                                    class="mt-2 w-32 h-32 object-cover rounded border border-gray-300">

                                                <button type="button" id="delete-image"
                                                    class="mt-2 text-red-500 hover:text-red-700">
                                                    <i class="mdi mdi-delete"></i> Hapus Gambar
                                                </button>
                                            </div>
                                        @endif
                        
                                        <input type="hidden" name="delete_image" id="delete_image_flag" value="0">

                                        <div id="image-input" style="display: {{ $category->image ? 'none' : 'block' }};">
                                            <input type="file" name="image" id="image"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        </div>
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
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2 @11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentImageDiv = document.getElementById('current-image');
            const imageInputDiv = document.getElementById('image-input');
            const deleteFlag = document.getElementById('delete_image_flag');

            if (document.getElementById('delete-image')) {
                document.getElementById('delete-image').addEventListener('click', function() {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Gambar akan dihapus!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            deleteFlag.value = "1";

                            if (currentImageDiv) currentImageDiv.remove();

                            imageInputDiv.style.display = 'block';
                        }
                    });
                });
            }
        });
    </script>
@endpush
