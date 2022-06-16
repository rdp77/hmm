@extends('layouts.frontend.default')
@section('title', __('pages.title'))
@section('titleContent', __('auth.login'))

@section('content')
<div id="reader"></div>
<h3 class="mt-4 text-center">
    {{ __('Atau') }}
</h3>
<div class="input-group">
    <div class="input-group-prepend">
        <div class="input-group-text">
            <i class="fas fa-fingerprint"></i>
        </div>
    </div>
    <input type="text" id="submit" name="maintance" class="form-control" maxlength="10" minlength="10"
        placeholder="Kode Unik Hardware" autofocus>
</div>
@endsection

@section('script')
<script src="https://unpkg.com/html5-qrcode@2.2.1/html5-qrcode.min.js" type="text/javascript"></script>
<script src="{{ asset('assets/pages/front.js') }}" type="text/javascript"></script>
@endsection