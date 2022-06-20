@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Data MTTR'))
@section('titleContent', __('MTTR'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('MTTR') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
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
                    <th>{{ __('Total Waktu Maintenance') }}</th>
                    <th>{{ __('Waktu Maintenance') }}</th>
                    <th>{{ __('Total Perbaikan') }}</th>
                    <th>{{ __('Waktu Mulai Maintenance') }}</th>
                    <th>{{ __('MTTR') }}</th>
                    <th>{{ __('Aksi') }}</th>
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
    var index = '{{ route('mttr.index') }}';    
</script>
<script src="{{ asset('assets/pages/data/core/mttr.js') }}"></script>
@endsection