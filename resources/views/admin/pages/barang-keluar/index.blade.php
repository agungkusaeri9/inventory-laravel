@extends('admin.layouts.app')
@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-4">Filter</h5>
                    <form action="{{ route('admin.barang-keluar.index') }}" method="get">
                        <div class='form-group mb-3 row'>
                            <div class="col-md-3">
                                <label for='barang_id' class='mb-2'>Barang</label>
                                <select name="barang_id" id="barang_id"
                                    class="form-control select2 @error('barang_id') is-invalid @enderror">
                                    <option value="" selected>Pilih Barang</option>
                                    @foreach ($data_barang as $barang)
                                        <option @selected($barang->id == request('barang_id')) value="{{ $barang->id }}">{{ $barang->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('barang_id')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <div class='form-group mb-3'>
                                    <label for='tanggal' class='mb-2'>Tanggal</label>
                                    <input type='date' name='tanggal'
                                        class='form-control @error('tanggal') is-invalid @enderror'
                                        value='{{ request('tanggal') ?? old('tanggal') }}'>
                                    @error('tanggal')
                                        <div class='invalid-feedback'>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md align-self-center mt-2">
                                <button class="btn btn-secondary text-white">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Barang Keluar</h4>
                        @can('Barang Keluar Create')
                            <a href="{{ route('admin.barang-keluar.create') }}"
                                class="btn my-2 mb-3 btn-sm py-2 btn-primary">Tambah
                                Barang Keluar</a>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    @canany(['Barang Keluar Edit', 'Barang Keluar Delete'])
                                        <th>Aksi</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->created_at->translatedFormat('d-m-Y H:i:s') }}</td>
                                        <td>{{ $item->barang->nama }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        @canany(['Barang Keluar Edit', 'Barang Keluar Delete'])
                                            <td>
                                                @can('Barang Keluar Edit')
                                                    <a href="{{ route('admin.barang-keluar.edit', $item->id) }}"
                                                        class="btn btn-sm py-2 btn-info">Edit</a>
                                                @endcan
                                                @can('Barang Keluar Delete')
                                                    <form action="javascript:void(0)" method="post" class="d-inline"
                                                        id="formDelete">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                            data-action="{{ route('admin.barang-keluar.destroy', $item->id) }}">Hapus</button>
                                                    </form>
                                                @endcan
                                            </td>
                                        @endcanany
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
<x-Admin.Datatable />
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <script>
        $(function() {
            $('.select2').select2({
                theme: 'bootstrap',
                debug: true
            })

        })
    </script>
@endpush
