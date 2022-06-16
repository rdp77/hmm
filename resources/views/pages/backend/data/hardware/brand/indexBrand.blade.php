@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Data Merk'))
@section('titleContent', __('Merk'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Merk') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="{{ route('brand.create') }}" class="btn btn-icon icon-left btn-primary mr-2">
            <i class="far fa-edit"></i>{{ __(' Tambah Merk') }}
        </a>
        <a href="{{ route('brand.recycle') }}" class="btn btn-icon icon-left btn-danger">
            <i class="far fa-trash-alt"></i>{{ __('Recycle Bin') }}
        </a>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th class="text-center">
                        {{ __('NO') }}
                    </th>
                    <th>
                        {{ __('Nama') }}
                    </th>
                    <th>{{ __('Alamat') }}</th>
                    <th>{{ __('No HP') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Website') }}</th>
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
    var index = '{{ route('brand.index') }}';    
</script>
<script src="{{ asset('assets/pages/data/hardware/indexBrand.js') }}"></script>
@endsection