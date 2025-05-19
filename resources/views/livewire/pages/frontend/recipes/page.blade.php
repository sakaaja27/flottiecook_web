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
                            <div class="absolute bottom-0 left-0 right-0 bg-slate-600 bg-opacity-80 py-2 px-4">
                                <p class="text-white text-lg md:text-lg font-bold">{{ $recipe->name }}</p>
                                <p class="text-white text-sm md:text-sm font-semibold">
                                    {{ Str::words($recipe->description, 50, '...') }}
                                </p>
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
    <div class="container mx-auto" data-aos="fade-up" data-aos-delay="100">
        <div class="w-full py-20">
            <h2 class="text-2xl font-bold text-center mb-8">Explore Recipes by Category</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-6">
                @foreach ($recipescategory as $category)
                    <div class="text-center">

                        <div class="relative w-full pb-[100%] rounded-lg overflow-hidden bg-gray-200 mb-2">
                            <img class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 hover:scale-90"
                                src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}">
                        </div>
                        <p class="mt-2 text-sm font-semibold">{{ $category->name }}</p>
                    </div>
                @endforeach
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
