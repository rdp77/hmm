@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Pengguna'))
@section('backToContent')
@include('pages.backend.components.backToContent',['url'=>route('brand.index')])
@endsection
@section('titleContent', __('Edit Pengguna'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Pengguna') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Pengguna') }}</div>
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
                        <input type="text" class="form-control" name="name" value="{{ $brand->name }}" autofocus>
                    </div>
                    <div class="form-group">
                        <div class="d-block">
                            <label class="control-label">{{ __('No HP') }}</label>
                        </div>
                        <input type="tel" class="form-control" value="{{ $brand->phone }}" name="phone">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <div class="d-block">
                            <label class="control-label">{{ __('Email') }}</label>
                        </div>
                        <input type="email" class="form-control" value="{{ $brand->email }}" name="email">
                    </div>
                    <div class="form-group">
                        <div class="d-block">
                            <label class="control-label">{{ __('Website') }}</label>
                        </div>
                        <input type="url" class="form-control" value="{{ $brand->website }}" name="website">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="email">{{ __('Alamat') }}</label>
                <textarea class="form-control" name="address" style="height:100px">{{ $brand->address }}</textarea>
            </div>
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary mr-1" onclick="update()" type="button">{{ __('pages.edit') }}</button>
        </div>
    </form>
</div>
@endsection
@section('script')
<script>
    var url = '{{ route('brand.update',$brand->id) }}';
    var index = '{{ route('brand.index') }}';
</script>
<script src="{{ asset('assets/pages/stored.js') }}"></script>
@endsection