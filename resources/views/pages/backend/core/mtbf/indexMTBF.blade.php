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
                    <th>{{ __('Serial Number') }}</th>
                    <th>{{ __('Code') }}</th>
                    <th>{{ __('Nama') }}</th>
                    <th>{{ __('Model') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Merk') }}</th>
                    <th>{{ __('Tanggal Pembelian') }}</th>
                    <th>{{ __('Tanggal Garansi') }}</th>
                    <th>{{ __('Deskripsi') }}</th>
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
    var index = '{{ route('hardware.index') }}';    
</script>
<script src="{{ asset('assets/pages/data/hardware/index.js') }}"></script>
@endsection