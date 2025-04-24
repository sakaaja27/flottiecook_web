<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
        <a href="/" class="logo d-flex align-items-center">
            <dotlottie-player src="https://lottie.host/336192b9-d622-4b80-a4b9-36d1edf9985a/LpDMtJFCjI.lottie"
                background="transparent" speed="1" style="width: 50px; height: 50px" loop
                autoplay></dotlottie-player>
            <h1 class="sitename">LattieCook</h1>
        </a>
        <nav id="navmenu" class="navmenu">
            <ul id="menu-list">
                <li><a href="./#hero" class="active">Home</a></li>
                <li><a href="./#recipes">Recipes</a></li>
                <li><a href="./#aibot">AiBot</a></li>
                <li><a href="./#publish">Publish Recipes</a></li>

                @auth
                    @if(Auth::user()->role == 'user')
                        <li><a href="{{route('recipt.index')}}">Dashboard</a></li>
                    @endif
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer; padding: 0; font: inherit;">
                                Logout
                            </button>
                        </form>
                    </li>
                @else
                    <li><a href="./login">Login</a></li>
                @endauth
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
    </div>
</header>
