@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Data Maintenance'))
@section('backToContent')
@include('pages.backend.components.backToContent',['url'=>route('maintenance.index')])
@endsection
@section('titleContent', __('Tambah Data Maintenance'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Data Maintenance') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Data Maintenance') }}</div>
@endsection

@section('content')
<h2 class="section-title">{{ $code }}</h2>
<p class="section-lead">
    {{ __('Kode unik setiap maintenance yang digenerate otomatis oleh system') }}
</p>
<div class="alert alert-info alert-has-icon">
    <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
    <div class="alert-body">
        <div class="alert-title">Informasi</div>
        Data diukur berdasarkan 1 hari (24 jam), data yang teridentifikasi sama akan terdeteksi duplicate.
    </div>
</div>
<form id="stored">
    <div class="card">
        <div class="card-header">
            <h4>Data Utama</h4>
        </div>
        <input type="hidden" name="code" value="{{ $code }}">
        <div class="card-body">
            <div class="form-group">
                <div class="d-block">
                    <label class="control-label">{{ __('Hardware') }}<code>*</code></label>
                </div>
                <select class="form-control select2" name="hardware">
                    @foreach ($hardware as $h)
                    <option value="{{ $h->id }}">{{ $h->name.__(' | ').$h->brand->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col">
                    <h2 class="section-title">MTBF</h2>
                    <div class="form-group">
                        <label class="control-label">
                            {{ __('Total Waktu Kerja (Tanpa Kerusakan)')}}<code>*</code>
                        </label>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control text-right" name="total_work" autofocus required>
                            <div class="input-group-append">
                                <div class="input-group-text">Jam</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('Waktu Kerusakan')}}<code>*</code>
                                </label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control text-right" name="breakdown[]" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">Jam</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Waktu Mulai Kerusakan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control timepicker" name="time_breakdown[]">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="mtbf"></div>
                    <div class="card-footer text-center">
                        <button class="btn btn-primary mr-1" type="button" id="addMTBF">
                            {{ __('Tambah Waktu Rusak') }}
                        </button>
                    </div>
                </div>
                <div class="col">
                    <h2 class="section-title">MTTR</h2>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="control-label">
                                    {{ __('Total Maintenance')}}<code>*</code>
                                </label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control text-right" name="maintenance_time[]"
                                        required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">Jam</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Waktu Maintenance</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control timepicker" name="start_time[]">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="mttr"></div>
                    <div class="card-footer text-center">
                        <button class="btn btn-primary mr-1" type="button" id="addMTTR">
                            {{ __('Tambah Maintenance') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="additional"></div>
    <div class="text-center">
        <button class="btn btn-light mr-1" id="addAdditional" type="button">
            {{ __('Tambah Ketergantungan Hardware') }}
        </button>
        <button class="btn btn-primary mr-1" type="button" onclick="save()">
            {{ __('Tambah Data Maintenance') }}
        </button>
    </div>
</form>
@endsection
@section('script')
<script>
    var url = '{{ route('maintenance.store') }}';
    var index = '{{ route('maintenance.index') }}';
    var getMaintenanceUrl = '{{ route('maintenance.getMaintenance') }}';
</script>
<script src="{{ asset('assets/pages/stored.js') }}"></script>
<script src="{{ asset('assets/pages/addMaintance.js') }}"></script>
@endsection