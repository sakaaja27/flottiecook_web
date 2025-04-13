@include('livewire.pages.components-frontend.head')

<body class="index-page mt-5">
    @include('livewire.pages.components-frontend.header')

    <section id="aibot" class="aibot section">
        <div class="container section-title d-flex flex-column align-items-center" data-aos="fade-up">
            <h1 class="font-bold text-black">Hello <span class="text-pink-400">AiBot</span></h1>
        </div>
        <div class="flex items-center justify-center text-center py-3">
            <h1 class="max-w-2xl">find your cooking recipe with the help of AiBot</h1>
        </div>
        <!-- Main Section -->
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="flex justify-end px-4 mb-4">
                <button onclick="showScreen('text')" class="text-pink-500 hover:text-pink-700 mr-2"
                    title="Cari dengan teks">
                    <i class="bi bi-fonts text-xl"></i>
                </button>
                <button onclick="showScreen('image')" class="text-green-500 hover:text-green-700"
                    title="Cari dengan gambar">
                    <i class="bi bi-camera2 text-xl"></i>
                </button>
            </div>

            @include('livewire.pages.frontend.aibot.recipe.textgemini')
            @include('livewire.pages.frontend.aibot.recipe.imagegemini')

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
    </script>
</body>
