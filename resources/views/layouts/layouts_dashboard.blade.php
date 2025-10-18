@include('partials.header_dashboard')
@stack('styles')
<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
      @include('partials.sidebar_dashboard')
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

<div class="page-heading">
    <h3>{{$judul}}s</h3>
</div>
<div class="page-content">
    <section class="row">
        @yield('row')
        @yield('page-content')
    </section>
</div>
@include('partials.footer_dashboard')
@stack('scripts')
