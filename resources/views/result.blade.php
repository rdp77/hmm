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
                                <td>{{ $hardware->status->value ?? __('Kosong') }}</td>
                                <td>{{ $hardware->purchase_date ?? __('Kosong') }}</td>
                                <td>{{ $hardware->warranty_date ?? __('Kosong') }}</td>
                                <td>{{ $hardware->description ?? __('Kosong') }}</td>
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
                                <td>{{ $hardware->brand->name ?? __('Kosong') }}</td>
                                <td>{{ $hardware->brand->address ?? __('Kosong') }}</td>
                                <td>{{ $hardware->brand->phone ?? __('Kosong') }}</td>
                                <td>{{ $hardware->brand->email ?? __('Kosong') }}</td>
                                <td>{{ $hardware->brand->website ?? __('Kosong') }}</td>
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
                                @foreach ($hardware->brand->spareparts as $s)
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
            <div class="container">
                <div class="row justify-content-center">
                    //
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/pages/data/hardware/customHardware.js') }}"></script>
@endsection