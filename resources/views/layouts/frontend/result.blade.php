@include('layouts.components.header')

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                @yield('content')
                <div class="simple-footer">
                    @include('layouts.components.credit')
                </div>
            </div>
        </section>
    </div>
    @include('layouts.components.footer')
    @yield('script')
</body>

</html>