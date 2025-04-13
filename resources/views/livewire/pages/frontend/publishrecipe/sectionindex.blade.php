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
            <form action="{{ route('recipt.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <div class="mb-4">
                            <label for="recipe_name" class="block text-sm font-medium text-gray-700">Recipe Name</label>
                            <input type="text" name="recipe_name" id="recipe_name" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50"
                                placeholder="Enter recipe name">
                        </div>

                        <div class="mb-4">
                            <label for="recipe_ingredients" class="block text-sm font-medium text-gray-700">Recipe
                                Ingredients</label>
                            <textarea name="recipe_ingredients" id="recipe_ingredients" rows="4" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50"
                                placeholder="Enter recipe ingredients"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="recipe_steps" class="block text-sm font-medium text-gray-700">Recipe
                                Steps</label>
                            <textarea name="recipe_steps" id="recipe_steps" rows="4" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50"
                                placeholder="Enter recipe steps"></textarea>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="recipe_description" class="block text-sm font-medium text-gray-700">Recipe
                            Description</label>
                        <textarea name="recipe_description" id="recipe_description" rows="4" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50"
                            placeholder="Enter recipe description"></textarea>
                        <div class="mb-4 mt-4">
                            <label for="recipe_category" class="block text-sm font-medium text-gray-700">Recipe
                                Category</label>
                            <input type="text" name="recipe_category" id="recipe_category" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50"
                                placeholder="Enter recipe category">
                        </div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Recipe</label>
                        <div id="image-upload-container">
                            <div class="image-upload-item flex items-center mb-2">
                                <input type="file" name="image[]"
                                    class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                    multiple>
                                <button type="button" class="ml-2 text-red-500 hover:text-red-700"
                                    onclick="removeImageInput(this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                <button type="button" class="ml-2 text-blue-500 hover:text-blue-700"
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
            </form>
            <div class="flex justify-center m-4">
                <button type="submit"
                    class="bg-pink-500 hover:bg-pink-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Publish Recipe
                </button>
            </div>
        </div>
        <div class="flex justify-center mt-4 ">
            <p class="text-sm text-gray-500">By publishing your recipe, you agree to our <a href="#"
                    class="text-pink-500 hover:text-pink-700">terms and conditions</a>.</p>
        </div>
    </section>
    @include('livewire.pages.components-frontend.footer')
</body>
