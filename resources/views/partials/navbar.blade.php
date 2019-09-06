		<header class="navbar navbar-expand navbar-dark flex-column flex-md-row" style="background-color: #10069f;">
            <a class="navbar-brand mr-0 mr-md-2" href="/">{{ config('app.name', 'Laravel') }}</a>
            <ul class="navbar-nav bd-navbar-nav ml-md-auto flex-row">
                @if (Auth::check())
                    <li class="nav-item dropdown">
                        <a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="userMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user"></i> {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userMenuLink">
                            <a class="dropdown-item" href="{{ route('user.profile') }}">
                                <i class="fa fa-user"></i> My Account
                            </a>
							<div class="dropdown-divider"></div>
                            <a class="dropdown-item" href=""
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i>  Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-user"></i> Login</a>
                    </li>
                @endif
            </ul>
        </header>
