<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <!-- <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
        <!-- academic icon -->
        <i class="fas fa-graduation-cap brand-image img-circle" style="opacity: .8; font-size: 25px;"></i>
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
        <!-- small badge -->
        <span class="badge badge-success ml-2font-weight-light text-sm">
            {{ str(auth()->user()->role_name)->title() }}
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <!-- <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
                <!-- profile image from name -->
                <div class="img-circle elevation-2" style="background-color: #3c8dbc; width: 35px; height: 35px; text-align: center; line-height: 35px; font-size: 18px; color: #fff;">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    {{ auth()->user()->name }}
                    <!-- ({{ auth()->user()->role_name }}) -->
                    <!-- <br> -->

                    <!-- ({{ str(auth()->user()->role_name)->title() }}) -->
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                @foreach ($menus as $menu)
                @if (isset($menu["children"]))
                <li class="nav-item has-treeview">
                    <a href="{{ route($menu['route']) }}" class="nav-link {{ request()->routeIs($menu['route']) ? 'active' : '' }}">
                        <i class="nav-icon {{ $menu['icon'] }}"></i>
                        <p>
                            {{ $menu["name"] }}
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right">
                                {{ count($menu["children"]) }}
                            </span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach ($menu["children"] as $child)
                        <li class="nav-item">
                            <a href="{{ route($child['route']) }}" class="nav-link {{ request()->routeIs($child['route']) ? 'active' : '' }}">
                                <i class="nav-icon {{ $child['icon'] }}"></i>
                                <p>{{ $child["name"] }}</p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                @else
                <li class="nav-item">
                    <a href="{{ route($menu['route']) }}" class="nav-link {{ request()->routeIs($menu['route']) ? 'active' : '' }}
                    ">
                        <i class="nav-icon {{ $menu['icon'] }}"></i>
                        <p>
                            {{ $menu["name"] }}
                        </p>
                    </a>
                </li>
                @endif
                @endforeach
                <!-- logout button -->
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            {{ __('Logout') }}

                        </p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf

                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>