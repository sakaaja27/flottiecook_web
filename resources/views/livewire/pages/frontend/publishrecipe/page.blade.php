<section id="publish" class="publish section">
    <div class="container section-title d-flex flex-column align-items-center" data-aos="fade-up">
        <h1 class="font-bold text-black">Publish <span class="text-pink-700">Recipes</span></h1>
    </div>
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4 justify-content-between">
            <div class="col-lg-4 order-lg-last hero-img" data-aos="zoom-out" data-aos-delay="100">
                <dotlottie-player src="https://lottie.host/866bcebe-c1e8-4920-8845-4faebe8539b1/nSVukLN1iG.lottie"
                    background="transparent" speed="1" style="width: 300px; height: 300px" loop
                    autoplay></dotlottie-player>
            </div>
            <div class="col-lg-6  d-flex flex-column justify-content-center" data-aos="fade-in">
                <h1>You can share the food recipe you made, click start to try it and start sharing</h1>
                <div class="d-flex mt-4">
                    <button type="button" id="startButton"
                        class="text-white bg-pink-700 hover:bg-pink-800 focus:outline-none focus:ring-4 focus:ring-pink-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-pink-600 dark:hover:bg-pink-700 dark:focus:ring-pink-800">
                        Started
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('startButton').addEventListener('click', function() {
        @if(auth()->check())
            window.location.href = "{{ route('page.recipes') }}";
        @else
            Swal.fire({
                title: 'Login Required',
                text: 'Silahkan Login terlebih dahulu',
                icon: 'warning',
                confirmButtonText: 'OK',
                confirmButtonColor: '#D14D72'
            });
        @endif
    });
</script>
