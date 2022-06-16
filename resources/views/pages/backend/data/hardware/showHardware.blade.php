@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Lihat Hardware'))
@section('backToContent')
@include('pages.backend.components.backToContent',['url'=>route('hardware.index')])
@endsection
@section('titleContent', __('Lihat Hardware'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Hardware') }}</div>
<div class="breadcrumb-item active">{{ __('Lihat Hardware') }}</div>
@endsection

@section('content')
<h2 class="section-title">{{ $hardware->code }}</h2>
<p class="section-lead">
    {{ __('Kode unik setiap hardware yang digenerate otomatis oleh system') }}
</p>
<div class="section-body">
    <div class="card">
        <div class="card-body">
            <div class="align-content-center">
            </div>
            <div class="container">
                <div class="row justify-content-center mb-2">
                    {!! $barcode !!}
                </div>
                <div class="row justify-content-center">
                    <div class="form-group">
                        <div class="d-block">
                            <label class="control-label">{{ __('Kode Hardware') }}</label>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" id="hardware_code" value="{{ $hardware->code }}" class="form-control"
                                readonly>
                            <div class="input-group-append">
                                <button class="btn btn-primary" onclick="getCode()" type="button">
                                    {{ __('Salin') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row justify-content-center mb-2">
                    {!! $serial_number !!}
                </div>
                <div class="row justify-content-center">
                    <div class="form-group">
                        <div class="d-block">
                            <label class="control-label">{{ __('Serial Number Hardware') }}</label>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" id="serial_number" value="{{ $hardware->serial_number }}"
                                class="form-control" readonly>
                            <div class="input-group-append">
                                <button class="btn btn-primary" onclick="getSerial()" type="button">
                                    {{ __('Salin') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-success btn-block" type="button">
                {{ __('Print Kode Hardware') }}
            </button>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/pages/data/hardware/customHardware.js') }}"></script>
@endsection