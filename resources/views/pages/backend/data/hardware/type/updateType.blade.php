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
            <div class="form-group">
                <div class="d-block">
                    <label class="control-label">{{ __('Merk') }}<code>*</code></label>
                </div>
                <select class="form-control select2" name="brand_id">
                    @foreach ($brand as $b)
                    <option value="{{ $b->id }}" {{ $b->id == $type->brand_id ? 'selected' : '' }}>
                        {{ $b->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <div class="d-block">
                            <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                        </div>
                        <input type="text" class="form-control" name="name" value="{{ $type->name }}" autofocus
                            required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <div class="d-block">
                            <label class="control-label">{{ __('Codename') }}</label>
                        </div>
                        <input type="text" class="form-control" name="codename" value="{{ $type->codename }}" required>
                    </div>
                </div>
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
    var url = '{{ route('type.update',$type->id) }}';
    var index = '{{ route('type.index') }}';
</script>
<script src="{{ asset('assets/pages/stored.js') }}"></script>
@endsection