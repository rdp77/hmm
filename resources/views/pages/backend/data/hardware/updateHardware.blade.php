@inject('function', 'App\Http\Controllers\Template\MainController')
@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Hardware'))
@section('backToContent')
@include('pages.backend.components.backToContent',['url'=>route('hardware.index')])
@endsection
@section('titleContent', __('Edit Hardware'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Hardware') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Hardware') }}</div>
@endsection

@section('content')
<h2 class="section-title">{{ $hardware->code }}</h2>
<p class="section-lead">
    {{ __('Kode unik setiap hardware yang digenerate otomatis oleh system') }}
</p>
<div class="card">
    <form id="stored">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <div class="d-block">
                            <label class="control-label">{{ __('Nama') }}<code>*</code></label>
                        </div>
                        <input type="text" class="form-control" value="{{ $hardware->name }}" name="name" autofocus>
                    </div>
                    <div class="form-group">
                        <div class="d-block">
                            <label class="control-label">{{ __('Serial Number') }}</label>
                        </div>
                        <input type="text" class="form-control" value="{{ $hardware->serial_number }}"
                            name="serial_number">
                    </div>
                    <div class="form-group">
                        <div class="d-block">
                            <label class="control-label">{{ __('Model') }}</label>
                        </div>
                        <input type="text" class="form-control" value="{{ $hardware->model }}" name="model">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <div class="d-block">
                            <label class="control-label">{{ __('Tanggal Pembelian') }}</label>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="purchase_date" class="form-control datepicker"
                                value="{{ $function->changeDateEnToId($hardware->purchase_date) }}" readonly>
                            <div class=" input-group-append">
                                <button class="btn btn-primary" id="datePurchase" type="button">
                                    {{ __('Kosongkan') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-block">
                            <label class="control-label">{{ __('Tanggal Garansi') }}</label>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="warranty_date" class="form-control datepicker"
                                value="{{ $function->changeDateEnToId($hardware->warranty_date) }}" readonly>
                            <div class="input-group-append">
                                <button class="btn btn-primary" id="dateWarranty" type="button">
                                    {{ __('Kosongkan') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-block">
                            <label class="control-label">{{ __('Status') }}<code>*</code></label>
                        </div>
                        <div class="selectgroup w-100">
                            @foreach ($status as $s)
                            <label class="selectgroup-item">
                                <input type="radio" name="status" value="{{ $s->value }}" class="selectgroup-input" {{
                                    $s->value == $hardware->status->value ? 'checked' : '' }}>
                                <span class="selectgroup-button">{{ strtoupper($s->value) }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="d-block">
                    <label class="control-label">{{ __('Merk') }}<code>*</code></label>
                </div>
                <select class="form-control select2" name="brand_id">
                    @foreach ($brand as $b)
                    <option value="{{ $b->id }}" {{ $b->id == $hardware->brand_id ? 'selected' : '' }}>
                        {{ $b->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="email">{{ __('Deskripsi') }}</label>
                <textarea class="form-control" name="description" style="height:100px"></textarea>
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
    var url = '{{ route('hardware.update',$hardware->id) }}';
    var index = '{{ route('hardware.index') }}';
    var warranty_date = '{{ $hardware->warranty_date }}';
    var purchase_date = '{{ $hardware->purchase_date }}';
</script>
<script src="{{ asset('assets/pages/stored.js') }}"></script>
<script src="{{ asset('assets/pages/data/hardware/customHardware.js') }}"></script>
@endsection