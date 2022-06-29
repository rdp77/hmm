@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | ').__('Maintenance'))
@section('backToContent')
@include('pages.backend.components.backToContent',['url'=>route('dashboard')])
@endsection
@section('ButtonHeader')
<a href="{{ route('maintenance.create') }}" class="btn btn-primary">Tambah</a>
@endsection
@section('titleContent', __('Maintenance'))
@section('breadcrumb', __('pages.dashboard'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Maintenance') }}</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-sm-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4>Statistics Uptime</h4>
            </div>
            <div class="card-body">
                <canvas id="uptime" height="182"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4>Statistics Maintenance</h4>
            </div>
            <div class="card-body">
                <div class="summary">
                    <div class="summary-chart active">
                        <canvas id="maintenance" height="180"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th class="text-center">
                        {{ __('NO') }}
                    </th>
                    <th>{{ __('Kode') }}</th>
                    <th>{{ __('Kode Hardware') }}</th>
                    <th>{{ __('Merk') }}</th>
                    <th>{{ __('MTBF') }}</th>
                    <th>{{ __('MTTR') }}</th>
                    <th>{{ __('Tanggal Maintenance') }}</th>
                    <th>{{ __('Availibility') }}</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script>
    var mtbf = {{ json_encode($mtbf) }};
    var mttr = {{ json_encode($mttr) }};
    var availibility = {{ json_encode($availibility) }};
    var index = '{{ route('maintenance.index') }}';    
</script>
<script type="text/javascript" src="{{ asset('assets/pages/maintance.js') }}"></script>
@endsection