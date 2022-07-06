@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | ').__('Kerusakan'))
@section('backToContent')
@include('pages.backend.components.backToContent',['url'=>route('dashboard')])
@endsection
@section('titleContent', __('Kerusakan'))
@section('breadcrumb', __('pages.dashboard'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Kerusakan') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
<div class="card">
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th class="text-center">
                        {{ __('NO') }}
                    </th>
                    <th>{{ __('Tipe Kerusakan') }}</th>
                    <th>{{ __('Catatan') }}</th>
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
    var index = '{{ route('data.damage') }}';    
</script>
<script type="text/javascript" src="{{ asset('assets/pages/damage.js') }}"></script>
@endsection