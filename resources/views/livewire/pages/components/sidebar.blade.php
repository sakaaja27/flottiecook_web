<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="{{ route ('dashboard') }}">
          <span class="menu-title">Dashboard</span>
          <i class="mdi mdi-home menu-icon"></i>
        </a>
      </li>
      {{-- <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Basic UI Elements</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-crosshairs-gps menu-icon"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/ui-features/dropdowns.html">Dropdowns</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/ui-features/typography.html">Typography</a>
            </li>
          </ul>
        </div>
      </li> --}}
      <li class="nav-item">
        <a class="nav-link" href="{{ route ('users.index') }}" aria-expanded="false" aria-controls="icons">
          <span class="menu-title">User</span>
          <i class="mdi mdi-contacts menu-icon"></i>
        </a>
        {{-- <div class="collapse" id="icons">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="pages/icons/font-awesome.html">Font Awesome</a>
            </li>
          </ul>
        </div> --}}
      </li>
      {{-- <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#forms" aria-expanded="false" aria-controls="forms">
          <span class="menu-title">Forms</span>
          <i class="mdi mdi-format-list-bulleted menu-icon"></i>
        </a>
        <div class="collapse" id="forms">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="pages/forms/basic_elements.html">Form Elements</a>
            </li>
          </ul>
        </div>
      </li> --}}
      {{-- <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
          <span class="menu-title">Charts</span>
          <i class="mdi mdi-chart-bar menu-icon"></i>
        </a>
        <div class="collapse" id="charts">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="pages/charts/chartjs.html">ChartJs</a>
            </li>
          </ul>
        </div>
      </li> --}}
      <li class="nav-item">
        <a class="nav-link" href="{{ route ('recipt.index') }}" aria-expanded="false" aria-controls="icons">
          <span class="menu-title">Recipe</span>
          <i class="mdi mdi-food menu-icon"></i>
        </a>
        {{-- <div class="collapse" id="icons">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="pages/icons/font-awesome.html">Font Awesome</a>
            </li>
          </ul>
        </div> --}}
      </li>
      {{-- <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
          <span class="menu-title">User Pages</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-lock menu-icon"></i>
        </a>
        <div class="collapse" id="auth">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="pages/samples/blank-page.html"> Blank Page </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/samples/login.html"> Login </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/samples/register.html"> Register </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/samples/error-404.html"> 404 </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/samples/error-500.html"> 500 </a>
            </li>
          </ul>
        </div>
      </li> --}}
      {{-- <li class="nav-item">
        <a class="nav-link" href="docs/documentation.html" target="_blank">
          <span class="menu-title">Documentation</span>
          <i class="mdi mdi-file-document-box menu-icon"></i>
        </a>
      </li> --}}
    </ul>
  </nav>
