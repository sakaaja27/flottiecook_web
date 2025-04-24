<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @if (auth()->user()->role == 'admin')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <span class="menu-title">Dashboard</span>
                    <i class="mdi mdi-home menu-icon"></i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}" aria-expanded="false" aria-controls="icons">
                    <span class="menu-title">User</span>
                    <i class="mdi mdi-contacts menu-icon"></i>
                </a>

            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('recipe.category.index') }}" aria-expanded="false"
                    aria-controls="icons">
                    <span class="menu-title">Recipe category</span>
                    <i class="mdi mdi-ballot menu-icon"></i>
                </a>

            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" href="{{ route('recipt.index') }}" aria-expanded="false" aria-controls="icons">
                <span class="menu-title">Recipe</span>
                <i class="mdi mdi-food menu-icon"></i>
            </a>
        </li>

    </ul>
</nav>
