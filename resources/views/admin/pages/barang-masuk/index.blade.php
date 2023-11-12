@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Barang Masuk</h4>
                        @can('Barang Masuk Create')
                            <a href="{{ route('admin.barang-masuk.create') }}"
                                class="btn my-2 mb-3 btn-sm py-2 btn-primary">Tambah
                                Barang Masuk</a>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Supplier</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                    @canany(['Barang Masuk Edit', 'Barang Masuk Delete'])
                                        <th>Aksi</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->supplier->nama }}</td>
                                        <td>{{ $item->barang->nama }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td>{{ $item->harga() }}</td>
                                        <td>{{ $item->total() }}</td>
                                        @canany(['Barang Masuk Edit', 'Barang Masuk Delete'])
                                            <td>
                                                @can('Barang Masuk Edit')
                                                    <a href="{{ route('admin.barang-masuk.edit', $item->id) }}"
                                                        class="btn btn-sm py-2 btn-info">Edit</a>
                                                @endcan
                                                @can('Barang Masuk Delete')
                                                    <form action="javascript:void(0)" method="post" class="d-inline"
                                                        id="formDelete">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                            data-action="{{ route('admin.barang-masuk.destroy', $item->id) }}">Hapus</button>
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
