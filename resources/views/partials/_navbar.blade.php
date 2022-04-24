<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom bg-dark">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#">
                <i class="fa fa-bars"></i>
            </a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown has-arrow main-drop">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <navbar-user-dropdown />
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('user-profile') }}">My Profile</a>
                <a class="dropdown-item" href="#" onclick="event.preventDefault();
          		document.getElementById('logout-navbar-form').submit();">
					{{ __('Logout') }}
			    </a>
                <form id="logout-navbar-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>