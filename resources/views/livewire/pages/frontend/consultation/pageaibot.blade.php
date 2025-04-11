@include('livewire.pages.components-frontend.head')

<body class="index-page mt-5">
    @include('livewire.pages.components-frontend.header')

    <section id="konsultasi" class="konsultasi section">
        <div class="container section-title d-flex flex-column align-items-center" data-aos="fade-up">
            <h1 class="font-bold text-black">Hello <span class="text-blue-400">AiBot</span></h1>
        </div>
        <div class="flex items-center justify-center text-center py-3">
            <h1 class="max-w-2xl">find your cooking recipe with the help of AiBot</h1>
        </div>
        <!-- Main Section -->
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="flex justify-end px-4 mb-4">
                <button onclick="showScreen('text')" class="text-blue-500 hover:text-blue-700 mr-2"
                    title="Cari dengan teks">
                    <i class="bi bi-fonts text-xl"></i>
                </button>
                <button onclick="showScreen('image')" class="text-green-500 hover:text-green-700"
                    title="Cari dengan gambar">
                    <i class="bi bi-camera2 text-xl"></i>
                </button>
            </div>
            {{-- <div id="text-screen" class="hidden">
                <div
                    class="flex flex-col md:flex-row items-start justify-start w-full space-y-4 md:space-y-0 md:space-x-4">
                    <div class="w-full md:w-1/2">
                        <label class="block text-lg font-semibold text-gray-700 mb-2">Search your recipe</label>
                        <input type="text" placeholder="Search your recipe"
                            class="w-full p-3 border rounded-lg bg-white shadow-md" />
                    </div>
                    <div class="w-full md:w-1/2 h-64 relative">
                        <div id="result-card"
                            class="w-[500px] h-[300px] p-1 border-2 border-gray-200 bg-gray-50 rounded-lg overflow-y-auto">
                            <div class="w-full mb-6 px-2">
                                <label class="font-bold text-blue-700">Name Recipe:</label>
                                <textarea id="namerecipe-textarea"
                                    class="w-full h-20 p-2 mt-1 border-2 border-blue-100 bg-blue-50 rounded-lg text-black placeholder-gray-500 resize-none"
                                    disabled placeholder="Nama resep yang dicari akan tampil disini"></textarea>
                            </div>
                            <div class="w-full mt-6 px-2">
                                <label class="font-bold text-green-600 block mt-2">Ingredients:</label>
                                <textarea id="ingredient-textarea"
                                    class="w-full h-60 p-2 mt-1 border-2 border-green-50 bg-green-50 rounded-lg text-black placeholder-gray-500 resize-none"
                                    disabled placeholder="Alat dan bahan yang dibutuhkan akan tampil disini"></textarea>
                            </div>
                            <div class="w-full mt-6 px-2">
                                <label class="font-bold text-yellow-600 block mt-2">Process:</label>
                                <textarea id="makeprocess-textarea"
                                    class="w-full h-60 p-2 mt-1 border-2 border-yellow-50 bg-yellow-50 rounded-lg text-black placeholder-gray-500 resize-none"
                                    disabled placeholder="Proses pembuatan akan tampil disini"></textarea>
                            </div>
                        </div>
                        <div id="loading-icon"
                            class="hidden absolute inset-0 flex items-center justify-center bg-gray-50 rounded-lg w-[650px] h-[300px]">
                            <i class="fas fa-spinner fa-spin text-2xl text-blue-500"></i>
                            <span class="ml-2 text-gray-700">Memproses gambar...</span>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div id="image-screen">
                <div
                    class="flex flex-col md:flex-row items-start justify-start w-full space-y-4 md:space-y-0 md:space-x-4">
                    <!-- Dropzone -->
                    <label for="dropzone-file"
                        class="flex flex-col items-center justify-center w-[600px] h-[300px] rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 relative">
                        <!-- Dropzone Content -->
                        <div id="dropzone-content" class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                <span class="font-semibold">Click to upload</span> or drag and drop
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG, or GIF (MAX. 600x300px)
                            </p>
                        </div>

                        <div id="image-preview"
                            class="hidden absolute inset-0 w-full h-full rounded-lg overflow-hidden">
                            <img id="preview-image" class="w-full h-full object-contain"
                                style="max-width: 600px; max-height: 450px" alt="Preview" />
                            <button onclick="removeImage()"
                                class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                                ×
                            </button>
                        </div>
                        <input id="dropzone-file" type="file" class="hidden"
                            accept=".svg, .png, .jpeg, .jpg, .gif" />
                    </label>

                    <!-- Result Area -->
                    <div class="w-full md:w-1/2 h-64 relative">
                        <div id="result-card"
                            class="w-[500px] h-[300px] p-1 border-2 border-gray-200 bg-gray-50 rounded-lg overflow-y-auto">
                            <div class="w-full mb-6 px-2">
                                <label class="font-bold text-blue-700">Nama Resep:</label>
                                <textarea id="namerecipe-textarea"
                                    class="w-full h-20 p-2 mt-1 border-2 border-blue-100 bg-blue-50 rounded-lg text-black placeholder-gray-500 resize-none"
                                    disabled placeholder="Nama resep yang dicari akan tampil disini"></textarea>
                            </div>
                            <div class="w-full mt-6 px-2">
                                <label class="font-bold text-green-600 block mt-2">Ingredient:</label>
                                <textarea id="ingredient-textarea"
                                    class="w-full h-60 p-2 mt-1 border-2 border-green-50 bg-green-50 rounded-lg text-black placeholder-gray-500 resize-none"
                                    disabled placeholder="Alat dan bahan yang dibutuhkan akan tampil disini"></textarea>
                            </div>
                            <div class="w-full mt-6 px-2">
                                <label class="font-bold text-yellow-600 block mt-2">Proses Pembuatan:</label>
                                <textarea id="makeprocess-textarea"
                                    class="w-full h-60 p-2 mt-1 border-2 border-yellow-50 bg-yellow-50 rounded-lg text-black placeholder-gray-500 resize-none"
                                    disabled placeholder="Proses pembuatan akan tampil disini"></textarea>
                            </div>
                        </div>
                        <div id="loading-icon"
                            class="hidden absolute inset-0 flex items-center justify-center bg-gray-50 rounded-lg w-[650px] h-[300px]">
                            <i class="fas fa-spinner fa-spin text-2xl text-blue-500"></i>
                            <span class="ml-2 text-gray-700">Memproses gambar...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('livewire.pages.components-frontend.footer')
    <script>
        function showScreen(mode) {
            const textScreen = document.getElementById('text-screen');
            const imageScreen = document.getElementById('image-screen');

            if (mode === 'text') {
                textScreen.classList.remove('hidden');
                imageScreen.classList.add('hidden');
            } else {
                textScreen.classList.add('hidden');
                imageScreen.classList.remove('hidden');
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            showScreen('image');
        });

        document.getElementById('dropzone-file').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file && /\.(svg|png|jpeg|jpg|gif)$/i.test(file.name)) {
                const reader = new FileReader();
                reader.onload = function(e) {

                    const imagePreview = document.getElementById('image-preview');
                    const previewImage = document.getElementById('preview-image');
                    const dropzoneContent = document.getElementById('dropzone-content');

                    if (file.type === 'image/svg+xml') {
                        previewImage.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                        dropzoneContent.classList.add('hidden');
                        sendImageToGemini(file);
                    } else {
                        const img = new Image();
                        img.onload = function() {
                            const canvas = document.createElement('canvas');
                            const ctx = canvas.getContext('2d');

                            canvas.width = 600;
                            canvas.height = 300;

                            ctx.drawImage(img, 0, 0, 600, 300);

                            canvas.toBlob(function(blob) {
                                const resizedFile = new File([blob], file.name, {
                                    type: file.type,
                                    lastModified: Date.now()
                                });

                                previewImage.src = URL.createObjectURL(blob);
                                imagePreview.classList.remove('hidden');
                                dropzoneContent.classList.add('hidden');

                                sendImageToGemini(resizedFile);
                            }, file.type, 0.8);
                        };
                        img.src = e.target.result;
                    }
                    // previewImage.src = e.target.result;
                    // imagePreview.classList.remove('hidden');
                    // dropzoneContent.classList.add('hidden');
                    // sendImageToGemini(file);
                };
                reader.readAsDataURL(file);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'File type not supported',
                    text: 'Please upload a SVG, PNG, JPEG, or GIF file.',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            }
        });

        function removeImage() {
            const imagePreview = document.getElementById('image-preview');
            const previewImage = document.getElementById('preview-image');
            const dropzoneContent = document.getElementById('dropzone-content');

            previewImage.src = '';
            imagePreview.classList.add('hidden');
            dropzoneContent.classList.remove('hidden');
            document.getElementById('dropzone-file').value = '';
        }

        async function sendImageToGemini(file) {
            const loadingIcon = document.getElementById('loading-icon');
            const nameRecipeTextarea = document.getElementById('namerecipe-textarea');
            const ingredientTextarea = document.getElementById('ingredient-textarea');
            const makeProcessTextarea = document.getElementById('makeprocess-textarea');
            loadingIcon.classList.remove('hidden');
            nameRecipeTextarea.value = '';
            ingredientTextarea.value = '';
            makeProcessTextarea.value = '';
            const formData = new FormData();
            formData.append('image', file);

            try {
                const response = await fetch('/aibotwithimage', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: formData
                });

                const data = await response.json();
                if (data.status === 'success') {
                    const result = data.result;
                    const nameRecipe = result.match(/\[NAMA MAKANAN\]([\s\S]*?)\[ALAT DAN BAHAN\]/);
                    const ingredient = result.match(/\[ALAT DAN BAHAN\]([\s\S]*?)\[CARA PEMBUATAN\]/);
                    const makeProcess = result.match(/\[CARA PEMBUATAN\]([\s\S]*)/);

                    console.log('Full result from API:', result);

                    nameRecipeTextarea.value = nameRecipe ? nameRecipe[1].replace(/\*/g, '').trim() : 'Tidak ada hasil';
                    ingredientTextarea.value = ingredient ? ingredient[1].replace(/\*/g, '').trim() : 'Tidak ada hasil';
                    makeProcessTextarea.value = makeProcess ? makeProcess[1].replace(/\*/g, '').trim() :
                        'Tidak ada hasil';
                } else {
                    nameRecipeTextarea.value = 'Tidak ada hasil';
                    ingredientTextarea.value = 'Tidak ada hasil';
                    makeProcessTextarea.value = 'Tidak ada hasil';
                }
            } catch (error) {
                nameRecipeTextarea.value = 'Error: ' + error.message;
                ingredientTextarea.value = 'Error: ' + error.message;
                makeProcessTextarea.value = 'Error: ' + error.message;
            } finally {
                loadingIcon.classList.add('hidden');
            }
        }
    </script>
</body>
