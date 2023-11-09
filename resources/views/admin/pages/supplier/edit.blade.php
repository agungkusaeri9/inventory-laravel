@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Edit Supplier</h4>
                    <form action="{{ route('admin.supplier.update', $item->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class='form-group mb-3'>
                            <label for='nama' class='mb-2'>Nama</label>
                            <input type='text' name='nama' class='form-control @error('nama') is-invalid @enderror'
                                value='{{ $item->nama ?? old('nama') }}'>
                            @error('nama')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='email' class='mb-2'>Email</label>
                            <input type='email' name='email' class='form-control @error('email') is-invalid @enderror'
                                value='{{ $item->email ?? old('email') }}'>
                            @error('email')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='nomor_telepon' class='mb-2'>Nomor Telepon</label>
                            <input type='text' name='nomor_telepon'
                                class='form-control @error('nomor_telepon') is-invalid @enderror'
                                value='{{ $item->nomor_telepon ?? old('nomor_telepon') }}'>
                            @error('nomor_telepon')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='nomor_fax' class='mb-2'>Nomor Fax</label>
                            <input type='text' name='nomor_fax'
                                class='form-control @error('nomor_fax') is-invalid @enderror'
                                value='{{ $item->nomor_fax ?? old('nomor_fax') }}'>
                            @error('nomor_fax')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='alamat' class='mb-2'>Alamat</label>
                            <textarea name='alamat' id='alamat' cols='30' rows='3'
                                class='form-control @error('alamat') is-invalid @enderror'>{{ $item->alamat ?? old('alamat') }}</textarea>
                            @error('alamat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('admin.supplier.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Update Supplier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
