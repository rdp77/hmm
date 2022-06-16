@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Sparepart'))
@section('backToContent')
<div class="section-header-back">
    <a href="{{ route('sparepart.index') }}" class="btn btn-icon">
        <i class="fas fa-arrow-left"></i>
    </a>
</div>
@endsection
@section('titleContent', __('Sparepart'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Sparepart') }}</div>
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
                    <th>{{ __('Nama') }}</th>
                    <th>{{ __('Stok') }}</th>
                    <th>{{ __('Merk') }}</th>
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
    var index = '{{ route('sparepart.recycle') }}';
</script>
<script src="{{ asset('assets/pages/data/hardware/indexSparepart.js') }}"></script>
@endsection