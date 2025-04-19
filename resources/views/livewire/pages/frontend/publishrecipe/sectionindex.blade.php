@include('livewire.pages.components-frontend.head')

<body class="index-page mt-5">
    @include('livewire.pages.components-frontend.header')
    <section id="publishrecipe" class="publishrecipe section">
        <div class="container section-title d-flex flex-column align-items-center" data-aos="fade-up">
            <h1 class="font-bold text-black">Publish Your <span class="text-pink-400">Recipe</span></h1>
        </div>
        <div class="flex items-center justify-center text-center py-3">
            <h1 class="max-w-2xl">Share your recipe with the world and let them enjoy your culinary creations!</h1>
        </div>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="100">
            <form action="{{ route('page.recipes.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Recipe Name</label>
                            <input type="text" name="name" id="name" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50"
                                placeholder="Enter recipe name">
                        </div>

                        <div class="mb-4">
                            <label for="ingredient" class="block text-sm font-medium text-gray-700">Recipe
                                Ingredients</label>
                            <textarea name="ingredient" id="ingredient" rows="4" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50"
                                placeholder="Enter recipe ingredients"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="tools" class="block text-sm font-medium text-gray-700">Recipe
                                Tools</label>
                            <textarea name="tools" id="tools" rows="4" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50"
                                placeholder="Enter recipe ingredients"></textarea>
                        </div>
                    </div>
                    <div class="mb-6">
                        <div class="mb-4">
                            <label for="instruction" class="block text-sm font-medium text-gray-700">Recipe
                                Steps</label>
                            <textarea name="instruction" id="instruction" rows="4" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50"
                                placeholder="Enter recipe steps"></textarea>
                        </div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Recipe
                            Description</label>
                        <textarea name="description" id="description" rows="4" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50"
                            placeholder="Enter recipe description"></textarea>
                        <div class="mb-4 mt-4">
                            <label for="recipe_category" class="block text-sm font-medium text-gray-700">Recipe
                                Category</label>
                            <select name="category_id" id="category_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50">
                                <option value="" disabled selected>Select a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Recipe Images (Max 3)</label>
                        <div id="image-upload-container">
                            <div class="image-upload-item flex items-center mb-2">
                                <input type="file" name="image_path[]" accept="image/*" required
                                    class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                <button type="button" class="ml-2 text-blue-500 hover:text-blue-700 add-btn"
                                    onclick="addImageInput(this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center m-4">
                    <button type="submit"
                        class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Publish Recipe
                    </button>
                </div>
            </form>
        </div>
        <div class="flex justify-center mt-4">
            <p class="text-sm text-gray-500">By publishing your recipe, you agree to our <a href="#"
                    class="text-pink-500 hover:text-pink-700">terms and conditions</a>.</p>
        </div>
    </section>

    @include('livewire.pages.components-frontend.footer')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let imageInputCount = 1;
        const maxImages = 3;
        function addImageInput(button) {
            if (imageInputCount >= maxImages) {
                Swal.fire({
                    title: 'Maximum Reached',
                    text: `You can only upload up to ${maxImages} images`,
                    icon: 'warning',
                    confirmButtonColor: '#D14D72'
                });
                return;
            }

            const container = document.getElementById('image-upload-container');
            const newItem = document.createElement('div');
            newItem.className = 'image-upload-item flex items-center mb-2';
            newItem.innerHTML = `
                <input type="file" name="image_path[]" accept="image/*"
                    class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                <button type="button" class="ml-2 text-red-500 hover:text-red-700"
                    onclick="removeImageInput(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
                ${imageInputCount < maxImages - 1 ? `
                <button type="button" class="ml-2 text-blue-500 hover:text-blue-700 add-btn"
                    onclick="addImageInput(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v16m8-8H4" />
                    </svg>
                </button>
                ` : ''}
            `;

            container.appendChild(newItem);
            imageInputCount++;
            if (imageInputCount >= maxImages) {
                document.querySelectorAll('.add-btn').forEach(btn => btn.style.display = 'none');
            }
        }

        function removeImageInput(button) {
            const container = document.getElementById('image-upload-container');
            const items = container.getElementsByClassName('image-upload-item');

            if (items.length <= 1) {
                Swal.fire({
                    title: 'Cannot Remove',
                    text: 'You need at least one image for your recipe',
                    icon: 'warning',
                    confirmButtonColor: '#D14D72'
                });
                return;
            }

            const itemToRemove = button.closest('.image-upload-item');
            container.removeChild(itemToRemove);
            imageInputCount--;
            if (imageInputCount < maxImages) {
                document.querySelectorAll('.add-btn').forEach(btn => btn.style.display = 'block');
            }
            const lastItem = items[items.length - 1];
            if (!lastItem.querySelector('.add-btn') && imageInputCount < maxImages) {
                const addButton = document.createElement('button');
                addButton.type = 'button';
                addButton.className = 'ml-2 text-blue-500 hover:text-blue-700 add-btn';
                addButton.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v16m8-8H4" />
                    </svg>
                `;
                addButton.onclick = function() { addImageInput(this); };
                lastItem.appendChild(addButton);
            }
        }

        document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        const submitButton = form.querySelector('button[type="submit"]');

        // Show loading state
        submitButton.disabled = true;
        submitButton.innerHTML = `
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Processing...
        `;

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Success!',
                    text: data.message,
                    icon: 'success',
                    confirmButtonColor: '#D14D72',
                    willClose: () => {
                        window.location.href = data.redirect;
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: data.message || 'Failed to save recipe',
                    icon: 'error',
                    confirmButtonColor: '#D14D72'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                title: 'Error!',
                text: 'An error occurred while saving the recipe',
                icon: 'error',
                confirmButtonColor: '#D14D72'
            });
            console.error('Error:', error);
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.innerHTML = 'Publish Recipe';
        });
    });
    </script>
</body>
