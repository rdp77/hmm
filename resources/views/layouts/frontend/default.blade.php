@include('layouts.components.header')

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div
                        class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                        <div class="login-brand">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="logo" width="150">
                        </div>
                        <div class="card card-dark">
                            <div class="card-body">
                                @yield('content')
                            </div>
                        </div>
                        <div class="mt-5 text-muted text-center">{{ __('Sudah punya akun?') }}
                            <a href="{{ route('login') }}"> {{
                                __('Login Sekarang') }}
                            </a>
                        </div>
                        <div class="simple-footer">
                            @include('layouts.components.credit')
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('layouts.components.footer')
    @yield('script')
</body>

</html>