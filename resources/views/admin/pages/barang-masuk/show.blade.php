@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Detail Barang Masuk</h4>
                    </div>
                    <table class="table table-borderless mt-4">
                        <tr>
                            <th>Kode</th>
                            <td>{{ $item->kode }}</td>
                        </tr>
                        <tr>
                            <th>Supplier</th>
                            <td>{{ $item->supplier->nama }}</td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $item->keterangan }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>{{ $item->tanggal->translatedFormat('d-m-Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Detail Barang</h4>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    @canany(['Barang Masuk Detail Delete'])
                                        <th>Aksi</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item->details as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->created_at->translatedFormat('d-m-Y H:i:s') }}</td>
                                        <td>{{ $item->barang->nama }}</td>
                                        <td>{{ formatRupiah($item->harga) }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td>{{ formatRupiah($item->total) }}</td>
                                        @canany(['Barang Masuk Detail Edit', 'Barang Masuk Detail Delete'])
                                            <td>
                                                @can('Barang Masuk Detail Edit')
                                                    <a href="{{ route('admin.barang-masuk-detail.edit', $item->uuid) }}"
                                                        class="btn btn-sm py-2 btn-info">Edit</a>
                                                @endcan
                                                @can('Barang Masuk Detail Delete')
                                                    <form action="javascript:void(0)" method="post" class="d-inline"
                                                        id="formDelete">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                            data-action="{{ route('admin.barang-masuk-detail.destroy', $item->uuid) }}">Hapus</button>
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
