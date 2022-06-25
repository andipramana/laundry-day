</div>
</div>
</div>

<aside class="control-sidebar control-sidebar-dark">
</aside>

<footer class="main-footer">
    <strong>Copyright &copy; 2022 <a href="/">Laundry Day</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
</footer>
</div>

<script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('template/dist/js/adminlte.js') }}"></script>

@if (Route::currentRouteNamed('employees*') || Route::currentRouteNamed('orders*'))
    @include('components.common.footerscripttable')
@endif

@yield('footerscript')

</body>

</html>
