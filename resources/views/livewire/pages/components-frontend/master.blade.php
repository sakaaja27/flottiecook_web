<!DOCTYPE html>
<html lang="en">

@include('livewire.pages.components-frontend.head')

<body class="index-page">
    @include('livewire.pages.components-frontend.header')
    <main class="main">
        @yield('content')
    </main>
    @include('livewire.pages.components-frontend.footer')
</body>

</html>
