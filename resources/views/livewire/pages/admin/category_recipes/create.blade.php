@extends('livewire.pages.components.main')

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-food"></i>
                </span> Add Recipe Category
            </h3>
        </div>

        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('recipe.category.index') }}"
                            class="text-indigo-600 font-medium mb-6 d-inline-block">
                            <i class="mdi mdi-arrow-left"></i> Back
                        </a>

                        <form id="category" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 row">
                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" id="name" name="name" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                        placeholder="Enter Food Name" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="image" class="col-sm-2 col-form-label">image</label>
                                <div class="col-sm-10">
                                    <input type="file" id="image" name="image" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                         />
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            $(document).on('submit', '#category', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('recipe.category.store') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = response.redirect;
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorMessage = '';
                            $.each(errors, function(key, value) {
                                errorMessage += value[0] + '\n';
                            });
                            Swal.fire({
                                title: 'Error!',
                                text: errorMessage,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'An unexpected error occurred.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush
