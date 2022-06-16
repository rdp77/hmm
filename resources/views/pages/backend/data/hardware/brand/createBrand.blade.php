@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Merk'))
@section('backToContent')
@include('pages.backend.components.backToContent',['url'=>route('users.index')])
@endsection
@section('titleContent', __('Tambah Merk'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Merk') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Merk') }}</div>
@endsection

@section('content')
<div class="card">
    <form id="stored">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <div class="d-block">
                            <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                        </div>
                        <input type="text" class="form-control" name="name" autofocus>
                    </div>
                    <div class="form-group">
                        <div class="d-block">
                            <label class="control-label">{{ __('No HP') }}</label>
                        </div>
                        <input type="tel" class="form-control" name="phone">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <div class="d-block">
                            <label class="control-label">{{ __('Email') }}</label>
                        </div>
                        <input type="email" class="form-control" name="email">
                    </div>
                    <div class="form-group">
                        <div class="d-block">
                            <label class="control-label">{{ __('Website') }}</label>
                        </div>
                        <input type="url" class="form-control" name="website">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="email">{{ __('Alamat') }}</label>
                <textarea class="form-control" name="address" style="height:100px"></textarea>
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-primary mr-1" type="button" onclick="save()">{{ __('Tambah') }}</button>
            </div>
        </div>
    </form>
</div>
@endsection
@section('script')
<script>
    var url = '{{ route('brand.store') }}';
    var index = '{{ route('brand.index') }}';
</script>
<script src="{{ asset('assets/pages/stored.js') }}"></script>
@endsection