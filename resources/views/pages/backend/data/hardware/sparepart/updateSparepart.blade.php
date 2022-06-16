@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Sparepart'))
@section('backToContent')
@include('pages.backend.components.backToContent',['url'=>route('sparepart.index')])
@endsection
@section('titleContent', __('Edit Sparepart'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Sparepart') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Sparepart') }}</div>
@endsection

@section('content')
<div class="card">
    <form id="stored">
        <div class="card-body">
            <div class="form-group">
                <div class="d-block">
                    <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                </div>
                <input id="name" type="text" class="form-control" value="{{ $sparepart->name }}" name="name" autofocus>
            </div>
            <div class="form-group">
                <div class="d-block">
                    <label class="control-label">{{ __('Stok') }}</label>
                </div>
                <input type="number" class="form-control" value="{{ $sparepart->stock }}" name="stock">
            </div>
            <div class="form-group">
                <div class="d-block">
                    <label class="control-label">{{ __('Merk') }}<code>*</code></label>
                </div>
                <select class="form-control select2" name="brand_id">
                    @foreach ($brand as $b)
                    <option value="{{ $b->id }}" {{ $b->id == $sparepart->brand_id ? 'selected' : '' }}>
                        {{ $b->name }}
                    </option>
                    @endforeach
                </select>
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
    var url = '{{ route('sparepart.update',$sparepart->id) }}';
    var index = '{{ route('sparepart.index') }}';
</script>
<script src="{{ asset('assets/pages/stored.js') }}"></script>
@endsection