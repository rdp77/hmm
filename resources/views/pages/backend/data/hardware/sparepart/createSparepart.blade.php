@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Sparepart'))
@section('backToContent')
@include('pages.backend.components.backToContent',['url'=>route('sparepart.index')])
@endsection
@section('titleContent', __('Tambah Sparepart'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Sparepart') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Sparepart') }}</div>
@endsection

@section('content')
<div class="card">
    <form id="stored">
        <div class="card-body">
            <div class="form-group">
                <div class="d-block">
                    <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                </div>
                <input id="name" type="text" class="form-control" name="name" autofocus>
            </div>
            <div class="form-group">
                <div class="d-block">
                    <label class="control-label">{{ __('Stok') }}</label>
                </div>
                <input type="number" class="form-control" name="stock">
            </div>
            <div class="form-group">
                <div class="d-block">
                    <label class="control-label">{{ __('Merk') }}<code>*</code></label>
                </div>
                <select class="form-control select2" name="brand_id">
                    @foreach ($brand as $b)
                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                    @endforeach
                </select>
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
    var url = '{{ route('sparepart.store') }}';
    var index = '{{ route('sparepart.index') }}';
</script>
<script src="{{ asset('assets/pages/stored.js') }}"></script>
@endsection