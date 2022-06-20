@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Data MTBF'))
@section('titleContent', __('MTBF'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('MTBF') }}</div>
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
                    <th>{{ __('Total Waktu Operasi') }}</th>
                    <th>{{ __('Total Waktu Kerusakan') }}</th>
                    <th>{{ __('Waktu Kerusakan') }}</th>
                    <th>{{ __('Waktu Mulai Kerusakan') }}</th>
                    <th>{{ __('MTBF') }}</th>
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
    var index = '{{ route('mtbf.index') }}';    
</script>
<script src="{{ asset('assets/pages/data/core/mtbf.js') }}"></script>
@endsection