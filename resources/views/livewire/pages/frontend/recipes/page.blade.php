<section id="recipes" class="recipes section">
    <div class="container section-title flex flex-col items-center" data-aos="fade-up">
        <h1 class="font-bold text-black">List <span class="text-pink-600">Recipes</span></h1>
    </div>
    <div class="container mb-8 flex justify-center" data-aos="fade-up">
        <div class="w-full max-w-full h-[320px]">
            <div class="swiper mySwiper w-full h-full rounded-xl overflow-hidden relative">
                <div class="swiper-wrapper">
                    @if ($data->isEmpty())
                        <div class="swiper-slide relative w-full h-full d-flex justify-center items-center">
                            <div class="absolute bg-gradient-to-t from-black/70 to-transparent">
                                <h2 class="text-black text-xl md:text-2xl font-bold">No Recipes Available</h2>
                            </div>
                        </div>
                    @endif
                    @foreach ($data as $recipe)
                        <div class="swiper-slide relative w-full h-full">
                            @if ($recipe->images->isNotEmpty())
                                <img class="w-full h-full object-cover"
                                    src="{{ asset('storage/' . $recipe->images->first()->image_path) }}"
                                    alt="Featured Recipe {{ $loop->iteration }}">
                            @endif
                            <div
                                class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                                <h2 class="text-white text-xl md:text-2xl font-bold">{{ $recipe->title }}</h2>
                            </div>
                        </div>
                    @endforeach


                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next text-white"></div>
                <div class="swiper-button-prev text-white"></div>
            </div>
        </div>
    </div>
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="w-full py-20">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <div class="text-center">
                    <img class="h-auto w-full rounded-lg transition duration-300 hover:scale-90"
                        src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-1.jpg" alt="Recipe 1">
                    <p class="mt-2 text-sm font-semibold">Dessert</p>
                </div>
                <div class="text-center">
                    <img class="h-auto w-full rounded-lg transition duration-300 hover:scale-90"
                        src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-2.jpg" alt="Recipe 2">
                    <p class="mt-2 text-sm font-semibold">Makanan Ringan</p>
                </div>
                <div class="text-center">
                    <img class="h-auto w-full rounded-lg transition duration-300 hover:scale-90"
                        src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-5.jpg" alt="Recipe 5">
                    <p class="mt-2 text-sm font-semibold">Makanan Berat</p>
                </div>
                <div class="text-center">
                    <img class="h-auto w-full rounded-lg transition duration-300 hover:scale-90"
                        src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-3.jpg" alt="Recipe 3">
                    <p class="mt-2 text-sm font-semibold">Minuman Panas</p>
                </div>
                <div class="text-center">
                    <img class="h-auto w-full rounded-lg transition duration-300 hover:scale-90"
                        src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-4.jpg" alt="Recipe 4">
                    <p class="mt-2 text-sm font-semibold">Minuman Dingin</p>
                </div>

                <div class="text-center">
                    <img class="h-auto w-full rounded-lg transition duration-300 hover:scale-90"
                        src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-1.jpg" alt="Recipe 1">
                    <p class="mt-2 text-sm font-semibold">Makanan Rendah Kalori</p>
                </div>
                <div class="text-center">
                    <img class="h-auto w-full rounded-lg transition duration-300 hover:scale-90"
                        src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-2.jpg" alt="Recipe 2">
                    <p class="mt-2 text-sm font-semibold">Ice Cream</p>
                </div>
                <div class="text-center">
                    <img class="h-auto w-full rounded-lg transition duration-300 hover:scale-90"
                        src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-3.jpg" alt="Recipe 3">
                    <p class="mt-2 text-sm font-semibold">Seafood</p>
                </div>
                <div class="text-center">
                    <img class="h-auto w-full rounded-lg transition duration-300 hover:scale-90"
                        src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-4.jpg" alt="Recipe 4">
                    <p class="mt-2 text-sm font-semibold">Resep Daging</p>
                </div>
                <div class="text-center">
                    <img class="h-auto w-full rounded-lg transition duration-300 hover:scale-90"
                        src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-5.jpg" alt="Recipe 5">
                    <p class="mt-2 text-sm font-semibold">Resep Ayam</p>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const swiper = new Swiper(".mySwiper", {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });

    });
</script>
