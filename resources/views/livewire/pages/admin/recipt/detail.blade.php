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
                        <form id="editReciptForm" method="POST" action="{{ route('recipt.update', $recipt->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3 row">
                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" id="name" name="name" value="{{ $recipt->name }}" disabled
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="category_id" class="col-sm-2 col-form-label">Category</label>
                                <div class="col-sm-10">

                                    <select name="category_id" id="category_id" disabled
                                        class="form-control {{ old('category_id', $recipt->category_id) ? 'text-black' : 'text-gray-500' }}"
                                        onchange="this.classList.remove('text-gray-500'); this.classList.add('text-black');">
                                        <option value="" disabled {{ !$recipt->category_id ? 'selected' : '' }}>--
                                            Pilih Kategori --</option>
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
                                    <input type="text" id="description" name="description"
                                        value="{{ $recipt->description }}" disabled
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="tools" class="col-sm-2 col-form-label">Tools</label>
                                <div class="col-sm-10">
                                    <input type="text" id="tools" name="tools" value="{{ $recipt->tools }}"
                                        disabled
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="ingredient" class="col-sm-2 col-form-label">Ingredients</label>
                                <div class="col-sm-10">
                                    <input type="text" id="ingredient" name="ingredient"
                                        value="{{ $recipt->ingredient }}" disabled
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="instruction" class="col-sm-2 col-form-label">Instructions</label>
                                <div class="col-sm-10">
                                    <input type="text" id="instruction" name="instruction"
                                        value="{{ $recipt->instruction }}" disabled
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="image_path" class="col-sm-2 col-form-label">Image</label>
                                <div class="col-sm-10" id="file-container">
                                    @if ($recipt->images && $recipt->images->count())
                                        <label class="form-label"></label>
                                        <div class="d-flex flex-wrap gap-2 mb-3">
                                            @foreach ($recipt->images as $image)
                                                <div class="position-relative me-2">
                                                    <img src="{{ asset('storage/' . $image->image_path) }}" width="100"
                                                        class="img-thumbnail">

                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @if(Auth::user()->role != 'user')
                            @if ($recipt->status == 'pending')
                                <div class="flex items-center justify-center space-x-4 mt-8 mb-4 ">
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:outline"
                                        type="button" id="approvedBtn" data-status="accept">
                                        <i class="mdi mdi-check"></i> accept
                                    </button>
                                    <button
                                        class="m-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:outline"
                                        type="button" id="rejectedBtn" data-status="reject">
                                        <i class="mdi mdi-close"></i> reject
                                    </button>
                                </div>
                            @endif
                            @endif
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
        function handleStatusChange(status) {
            const statusText = status.charAt(0).toUpperCase() + status.slice(1);
            console.log("Clicked:", status);
            Swal.fire({
                title: `${statusText} this recipe?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: `Yes, ${status}`,
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ route('recipt.approve', $recipt->id) }}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                status: status
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: data.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = data.redirect;
                                });
                            } else {
                                Swal.fire('Error', 'Something went wrong!', 'error');
                            }
                        });
                }
            });
        }
        document.getElementById("approvedBtn").addEventListener("click", function() {
            handleStatusChange('accept');
        });
        document.getElementById("rejectedBtn").addEventListener("click", function() {
            handleStatusChange('reject');
        });
    </script>
@endpush
