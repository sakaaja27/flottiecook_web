<footer id="footer" class="footer dark-background py-4">
    <div class="container mx-auto px-4">
        <!-- Logo dan Konten Utama -->
        <div class="flex flex-col items-center text-center">
            <!-- Logo -->
            <div class="logo mb-6">
                <a href="#" class="flex items-center">
                    <dotlottie-player src="https://lottie.host/336192b9-d622-4b80-a4b9-36d1edf9985a/LpDMtJFCjI.lottie"
                        background="transparent" speed="1" style="width: 50px; height: 50px" loop
                        autoplay></dotlottie-player>

                    <span class="sitename text-2xl font-bold ml-2 text-white">LattieCook</span>
                </a>
            </div>

            <!-- Daftar Link (ul li) -->
            <ul class="flex flex-wrap justify-center gap-6 mb-6">
                <li><a href="#" class="text-white text-xl">Home</a></li>
                <li><a href="#recipes" class="text-white text-xl">Recipes</a></li>
                <li><a href="#Aibot" class="text-white text-xl">AiBot</a></li>
                <li><a href="#publis" class="text-white text-xl">Publish Recipes</a></li>
                <li><a href="/login" class="text-white text-xl">Login</a></li>
            </ul>

            <!-- Social Media -->
            <div class="social-links flex gap-4">
                <a href="#" class="text-white"><i class="bi bi-twitter-x"></i></a>
                <a href="#" class="text-white"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-white"><i class="bi bi-instagram"></i></a>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="text-center mt-8 pt-8 border-t border-gray-700">
        <p class="text-sm text-white">
            © <span>Copyright</span> <strong class="px-1 sitename">LattieCook</strong> <span>All Rights Reserved</span>
        </p>
    </div>
</footer>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
<script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
<link href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" rel="stylesheet" />
<div id="osm-map"></div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Main JS File -->
<script src="{{ asset('assets/js/main.js') }}"></script>
