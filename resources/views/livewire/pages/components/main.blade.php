<!DOCTYPE html>
<html lang="en">
@include('livewire.pages.components.head')

<body>
    <div class="container-scroller">
    </div>
    <!-- partial:partials/_navbar -->
    @include('livewire.pages.components.header')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar -->
        @include('livewire.pages.components.sidebar')
        <!-- partial -->
        <div class="main-panel">
            @yield('content')
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            @include('livewire.pages.components.footer')
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>
    <script src="{{asset ('assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{asset ('assets/vendors/chart.js/chart.umd.js')}}"></script>
    <script src="{{asset ('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset ('assets/js/off-canvas.js')}}"></script>
    <script src="{{asset ('assets/js/misc.js')}}"></script>
    <script src="{{asset ('assets/js/settings.js')}}"></script>
    <script src="{{asset ('assets/js/todolist.js')}}"></script>
    <script src="{{asset ('assets/js/jquery.cookie.js')}}"></script>
    <script src="{{asset ('assets/js/dashboard.js')}}"></script>
</body>

</html>
