@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Hardware'))
@section('backToContent')
<div class="section-header-back">
    <a href="{{ route('hardware.index') }}" class="btn btn-icon">
        <i class="fas fa-arrow-left"></i>
    </a>
</div>
@endsection
@section('titleContent', __('Hardware'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Hardware') }}</div>
<div class="breadcrumb-item active">{{ __('Recycle Bin') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <div class="card-header-action">
            <button onclick="delAll()" class="btn btn-icon icon-left btn-danger">
                <i class="far fa-trash-alt"></i>{{ __('Hapus Semua') }}
            </button>
        </div>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th class="text-center">
                        {{ __('NO') }}
                    </th>
                    <th>{{ __('Serial Number') }}</th>
                    <th>{{ __('Barcode') }}</th>
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
    var index = '{{ route('hardware.recycle') }}';
</script>
<script src="{{ asset('assets/pages/data/hardware/index.js') }}"></script>
@endsection