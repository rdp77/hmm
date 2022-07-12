@php
use Illuminate\Support\Carbon;
@endphp
@extends('layouts.frontend.result')
@section('title', __('pages.title'))
@section('titleContent', __('auth.login'))

@section('content')
<div class="card card-dark">
    <div class="card-body">
        <h2 class="section-title">{{ $hardware->code }}</h2>
        <p class="section-lead">
            {{ __('Kode unik setiap hardware yang digenerate otomatis oleh system') }}
        </p>
        <div class="card-body">
            <div class="container">
                <div class="row justify-content-center mb-2">
                    {!! $barcode !!}
                </div>
                <div class="row justify-content-center">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="text" id="hardware_code" value="{{ $hardware->code }}" class="form-control"
                                readonly>
                            <div class="input-group-append">
                                <button class="btn btn-primary" onclick="getCode()" type="button">
                                    {{ __('Salin') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <h2 class="section-title">{{ __('Detail Hardware') }}</h2>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Serial Number</th>
                                <th scope="col">Model</th>
                                <th scope="col">Status</th>
                                <th scope="col">Tanggal Pembelian</th>
                                <th scope="col">Tanggal Garansi</th>
                                <th scope="col">Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $hardware->name ?? __('Kosong') }}</td>
                                <td>{{ $hardware->serial_number ?? __('Kosong') }}</td>
                                <td>{{ $hardware->model ?? __('Kosong') }}</td>
                                <td>
                                    @if ($hardware->status->value == 'baru')
                                    <span class="badge badge-success">
                                        {{ Str::headline($hardware->status->value) }}
                                    </span>
                                    @elseif ($hardware->status->value == 'normal')
                                    <span class="badge badge-primary">
                                        {{ Str::headline($hardware->status->value) }}
                                    </span>
                                    @elseif ($hardware->status->value == 'rusak')
                                    <span class="badge badge-danger">
                                        {{ Str::headline($hardware->status->value) }}
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($hardware->purchase_date == null)
                                    {{ __('Kosong') }}
                                    @else
                                    {{ Carbon::parse($hardware->purchase_date)->isoFormat('dddd, D-MMM-Y') }}
                                    @endif
                                </td>
                                <td>
                                    @if ($hardware->warranty_date == null)
                                    {{ __('Kosong') }}
                                    @else
                                    {{ Carbon::parse($hardware->warranty_date)->isoFormat('dddd, D-MMM-Y') }}
                                    @endif
                                </td>
                                <td>
                                    {{ $hardware->description??__('Kosong')}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <h2 class="section-title">{{ __('Merk') }}</h2>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">No HP</th>
                                <th scope="col">Email</th>
                                <th scope="col">Website</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $hardware->type->brand->name ?? __('Kosong') }}</td>
                                <td>{{ $hardware->type->brand->address ?? __('Kosong') }}</td>
                                <td>{{ $hardware->type->brand->phone ?? __('Kosong') }}</td>
                                <td>{{ $hardware->type->brand->email ?? __('Kosong') }}</td>
                                @php
                                $link = '<a href="http://' . $hardware->type->brand->website . '" target="_blank">' .
                                    $hardware->type->brand->website .
                                    '</a>';
                                @endphp
                                <td>{!! $hardware->type->brand->website ? $link: __('Kosong') !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <h2 class="section-title">{{ __('Sparepart') }}</h2>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach ($hardware->type->brand->spareparts as $s)
                                <td>{{ $s->name ?? __('Kosong') }}</td>
                                <td>{{ $s->stock ?? __('Kosong') }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4>Data Maintenance</h4>
    </div>
    <div class="card-body">
        <div class="card-body">
            <ul class="nav nav-pills justify-content-center" id="myTab3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" id="mtbf-tab" data-toggle="tab" href="#mtbf" role="tab" aria-controls="mtbf"
                        aria-selected="false">MTBF</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="maintenance-tab" data-toggle="tab" href="#maintenance" role="tab"
                        aria-controls="maintenance" aria-selected="true">Maintenance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="mttr-tab" data-toggle="tab" href="#mttr" role="tab" aria-controls="mttr"
                        aria-selected="false">MTTR</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent2">
                <div class="tab-pane fade" id="mtbf" role="tabpanel" aria-labelledby="mtbf-tab">
                    <div class="table-responsive">
                        <table class="table-striped table" id="mtbf-table" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        {{ __('NO') }}
                                    </th>
                                    <th>{{ __('Kode') }}</th>
                                    <th>{{ __('Merk') }}</th>
                                    <th>{{ __('Total Waktu Operasi') }}</th>
                                    <th>{{ __('Total Waktu Kerusakan') }}</th>
                                    <th>{{ __('Waktu Kerusakan') }}</th>
                                    <th>{{ __('Waktu Mulai Kerusakan') }}</th>
                                    <th>{{ __('MTBF') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade show active" id="maintenance" role="tabpanel"
                    aria-labelledby="maintenance-tab">
                    <div class="table-responsive">
                        <table class="table-striped table" id="maintenance-table" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        {{ __('NO') }}
                                    </th>
                                    <th>{{ __('Kode') }}</th>
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
                <div class="tab-pane fade" id="mttr" role="tabpanel" aria-labelledby="mttr-tab">
                    <div class="table-responsive">
                        <table class="table-striped table" id="mttr-table" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        {{ __('NO') }}
                                    </th>
                                    <th>{{ __('Kode') }}</th>
                                    <th>{{ __('Merk') }}</th>
                                    <th>{{ __('Total Waktu Maintenance') }}</th>
                                    <th>{{ __('Waktu Maintenance') }}</th>
                                    <th>{{ __('Total Perbaikan') }}</th>
                                    <th>{{ __('Waktu Mulai Maintenance') }}</th>
                                    <th>{{ __('MTTR') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if (count($dependency) > 0)
<div class="card">
    <div class="card-header">
        <h4>Data Ketergantungan</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Kode Maintenance</th>
                        <th scope="col">Kode Hardware</th>
                        <th scope="col">MTBF</th>
                        <th scope="col">MTTR</th>
                        <th scope="col">Availibility</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dependency as $d)
                    <tr>
                        <td>
                            {{ $d->maintenance->detail->code }}
                        </td>
                        <td>
                            {{ $d->maintenance->hardware->code }}
                        </td>
                        <td>
                            {{ $d->maintenance->mtbf->total." Jam" }}
                        </td>
                        <td>
                            {{ $d->maintenance->mttr->total." Jam" }}
                        </td>
                        <td>
                            {{ $d->maintenance->availability."%" }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

@endsection

@section('script')
<script>
    var mtbf = '{{ route('data.mtbf',$hardware->id) }}';  
    var mttr = '{{ route('data.mttr',$hardware->id) }}';    
    var maintenance = '{{ route('data.maintenance',$hardware->id) }}';      
</script>
<script src="{{ asset('assets/pages/result.js') }}"></script>
@endsection