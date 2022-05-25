@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | ').__('Base Formula'))
@section('backToContent')
@include('pages.backend.components.backToContent',['url'=>route('dashboard')])
@endsection
@section('titleContent', __('Base Formula'))
@section('breadcrumb', __('pages.dashboard'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Base Formula') }}</div>
@endsection

@section('content')
<div class="card card-dark">
    <div class="card-body">
        <div class="list-unstyled list-unstyled-border mt-4">
            <div class="media">
                <div class="media-icon"><i class="far fa-circle"></i></div>
                <div class="media-body">
                    <h6>{{ __('MTBF (Mean Time Between Failure)') }}</h6>
                    <p>by Marina D</p>
                    <div class="text-center">
                        <img class="img-responsive m-5" src="{{ asset('assets/img/mtbf.svg') }}">
                    </div>
                </div>
            </div>
            <div class="media">
                <div class="media-icon"><i class="far fa-circle"></i></div>
                <div class="media-body">
                    <h6>{{ __('MTTR (Mean Time To Repair)') }}</h6>
                    <p>by @mdo and @fat</p>
                    <div class="text-center">
                        <img class="img-responsive m-5" src="{{ asset('assets/img/mttr.svg') }}">
                    </div>
                </div>
            </div>
            <div class="media">
                <div class="media-icon"><i class="far fa-circle"></i></div>
                <div class="media-body">
                    <h6>{{ __('Availibility') }}</h6>
                    <p>by Marina D</p>
                    <div class="text-center">
                        <img class="img-responsive m-5" src="{{ asset('assets/img/mtbf.svg') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    var index = '{{ route('dashboard.log') }}';    
</script>
@endsection