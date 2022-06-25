<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a class="nav-link {{ Route::currentRouteNamed('employees*') ? 'active' : '' }}" href="/employees">Employees</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a class="nav-link {{ Route::currentRouteNamed('orders*') ? 'active' : '' }}" href="/orders">Orders</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

    </ul>
</nav>
