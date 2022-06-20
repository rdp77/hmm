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
                <div class="card-header-action">
                    <div class="btn-group">
                        <a href="#" class="btn btn-primary">Week</a>
                        <a href="#" class="btn">Month</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <canvas id="myChart" height="182"></canvas>
                <div class="statistic-details mt-sm-4">
                    <div class="statistic-details-item">
                        <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span>
                            7%</span>
                        <div class="detail-value">$243</div>
                        <div class="detail-name">Today's Sales</div>
                    </div>
                    <div class="statistic-details-item">
                        <span class="text-muted"><span class="text-danger"><i class="fas fa-caret-down"></i></span>
                            23%</span>
                        <div class="detail-value">$2,902</div>
                        <div class="detail-name">This Week's Sales</div>
                    </div>
                    <div class="statistic-details-item">
                        <span class="text-muted"><span class="text-primary"><i
                                    class="fas fa-caret-up"></i></span>9%</span>
                        <div class="detail-value">$12,821</div>
                        <div class="detail-name">This Month's Sales</div>
                    </div>
                    <div class="statistic-details-item">
                        <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span>
                            19%</span>
                        <div class="detail-value">$92,142</div>
                        <div class="detail-name">This Year's Sales</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4>Statistics Maintance</h4>
                <div class="card-header-action">
                    <a href="#summary-chart" data-tab="summary-tab" class="btn active">Chart</a>
                    <a href="#summary-text" data-tab="summary-tab" class="btn">Text</a>
                </div>
            </div>
            <div class="card-body">
                <div class="summary">
                    <div class="summary-info" data-tab-group="summary-tab" id="summary-text">
                        <h4>$1,858</h4>
                        <div class="text-muted">Sold 4 items on 2 customers</div>
                        <div class="d-block mt-2">
                            <a href="#">View All</a>
                        </div>
                    </div>
                    <div class="summary-chart active" data-tab-group="summary-tab" id="summary-chart">
                        <canvas id="myCharts" height="180"></canvas>
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
    var index = '{{ route('maintenance.index') }}';    
</script>
<script type="text/javascript" src="{{ asset('assets/pages/maintance.js') }}"></script>
@endsection