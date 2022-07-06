@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Hardware'))
@section('backToContent')
@include('pages.backend.components.backToContent',['url'=>route('hardware.index')])
@endsection
@section('titleContent', __('Tambah Hardware'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Hardware') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Hardware') }}</div>
@endsection

@section('content')
<h2 class="section-title">{{ $code }}</h2>
<p class="section-lead">
    {{ __('Kode unik setiap hardware yang digenerate otomatis oleh system') }}
</p>
<div class="section-body">
    <div class="card">
        <form id="stored">
            <input type="hidden" name="code" value="{{ $code }}">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <div class="d-block">
                                <label class="control-label">{{ __('Nama') }}<code>*</code></label>
                            </div>
                            <input type="text" class="form-control" name="name" autofocus>
                        </div>
                        <div class="form-group">
                            <div class="d-block">
                                <label class="control-label">{{ __('Serial Number') }}</label>
                            </div>
                            <input type="text" class="form-control" name="serial_number">
                        </div>
                        <div class="form-group">
                            <div class="d-block">
                                <label class="control-label">{{ __('Model') }}</label>
                            </div>
                            <select class="form-control select2" name="type_id">
                                @foreach ($type as $t)
                                <option value="{{ $t->id }}">{{ $t->name." | ".$t->brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <div class="d-block">
                                <label class="control-label">{{ __('Tanggal Pembelian') }}</label>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" name="purchase_date" class="form-control datepicker" readonly>
                                <div class="input-group-append">
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
                                <input type="text" name="warranty_date" class="form-control datepicker" readonly>
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
                                    <input type="radio" name="status" value="{{ $s->value }}" class="selectgroup-input">
                                    <span class="selectgroup-button">{{ strtoupper($s->value) }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">{{ __('Deskripsi') }}</label>
                    <textarea class="form-control" name="description" style="height:100px"></textarea>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary mr-1" type="button" onclick="save()">{{ __('Tambah') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script>
    var url = '{{ route('hardware.store') }}';
    var index = '{{ route('hardware.index') }}';
</script>
<script src="{{ asset('assets/pages/stored.js') }}"></script>
<script src="{{ asset('assets/pages/data/hardware/customHardware.js') }}"></script>
@endsection