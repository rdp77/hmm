@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Data Tipe'))
@section('titleContent', __('Tipe'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Tipe') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <a href="{{ route('type.create') }}" class="btn btn-icon icon-left btn-primary mr-2">
            <i class="far fa-edit"></i>{{ __(' Tambah Tipe') }}
        </a>
        <a href="{{ route('type.recycle') }}" class="btn btn-icon icon-left btn-danger">
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
                    <th>
                        {{ __('Codename') }}
                    </th>
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
    var index = '{{ route('type.index') }}';    
</script>
<script src="{{ asset('assets/pages/data/hardware/indexType.js') }}"></script>
@endsection