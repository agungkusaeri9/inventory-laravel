@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Edit Barang Masuk Detail</h4>
                    <form action="{{ route('admin.barang-masuk-detail.update', $item->uuid) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class='form-group mb-3'>
                            <label for='nama_barang' class='mb-2'>Nama Barang</label>
                            <input type='text' name='nama_barang'
                                class='form-control @error('nama_barang') is-invalid @enderror'
                                value='{{ $item->barang->nama ?? old('nama_barang') }}' disabled>
                            @error('nama_barang')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='kode' class='mb-2'>Kode Barang</label>
                            <input type='text' name='kode' class='form-control @error('kode') is-invalid @enderror'
                                value='{{ $item->barang->kode ?? old('kode') }}' disabled>
                            @error('kode')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='jumlah' class='mb-2'>Jumlah</label>
                            <input type='text' name='jumlah' class='form-control @error('jumlah') is-invalid @enderror'
                                value='{{ $item->jumlah ?? old('jumlah') }}'>
                            @error('jumlah')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='harga' class='mb-2'>Harga</label>
                            <input type='text' name='harga' class='form-control @error('harga') is-invalid @enderror'
                                value='{{ $item->harga ?? old('harga') }}'>
                            @error('harga')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <a href="{{ route('admin.barang-masuk.show', $item->barang_masuk->uuid) }}"
                                class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
