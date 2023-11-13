@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Edit Barang Masuk</h4>
                    <form action="{{ route('admin.barang-masuk.update', $item->id) }}" method="post">
                        @csrf
                        @method('patch')
                        <div class='form-group mb-3'>
                            <label for='nama' class='mb-2'>Nama Barang</label>
                            <input type='text' name='nama' class='form-control @error('nama') is-invalid @enderror'
                                value='{{ $item->barang->nama ?? old('nama') }}' readonly>
                            @error('nama')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='kode' class='mb-2'>Kode</label>
                            <input type='text' name='kode' class='form-control @error('kode') is-invalid @enderror'
                                value='{{ $item->barang->kode ?? old('kode') }}' readonly>
                            @error('kode')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='jenis' class='mb-2'>Jenis</label>
                            <input type='text' name='jenis' class='form-control @error('jenis') is-invalid @enderror'
                                value='{{ $item->barang->jenis->nama ?? old('jenis') }}' readonly>
                            @error('jenis')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='satuan' class='mb-2'>Satuan</label>
                            <input type='text' name='satuan' class='form-control @error('satuan') is-invalid @enderror'
                                value='{{ $item->barang->satuan->nama ?? old('satuan') }}' readonly>
                            @error('satuan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='stok' class='mb-2'>Stok</label>
                            <input type='text' name='stok' class='form-control @error('stok') is-invalid @enderror'
                                value='{{ $item->barang->stok ?? old('stok') }}' readonly>
                            @error('stok')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='jumlah' class='mb-2'>Jumlah</label>
                            <input type='number' name='jumlah' class='form-control @error('jumlah') is-invalid @enderror'
                                value='{{ $item->jumlah ?? old('jumlah') }}'>
                            @error('jumlah')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='harga' class='mb-2'>Harga</label>
                            <input type='number' name='harga' class='form-control @error('harga') is-invalid @enderror'
                                value='{{ $item->harga ?? old('harga') }}'>
                            @error('harga')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='total' class='mb-2'>Total</label>
                            <input type='text' name='total' class='form-control @error('total') is-invalid @enderror'
                                value='{{ $item->total ?? old('total') }}' readonly>
                            @error('total')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='supplier' class='mb-2'>Supplier</label>
                            <input type='text' name='supplier'
                                class='form-control @error('supplier') is-invalid @enderror'
                                value='{{ $item->supplier->nama ?? old('supplier') }}' readonly>
                            @error('supplier')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='keterangan' class='mb-2'>Keterangan</label>
                            <textarea name='keterangan' id='keterangan' cols='30' rows='3'
                                class='form-control @error('keterangan') is-invalid @enderror'>{{ $item->keterangan ?? old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('admin.barang-masuk.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Update Barang Masuk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <script>
        $(function() {
            function formatRupiah(inputAngka) {
                let rupiah = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(inputAngka);
                return rupiah;
            }

            function hitungTotal() {
                // Mengambil nilai dari kedua input
                var jumlah = parseInt($('input[name=jumlah]').val())
                var harga = parseInt($('input[name=harga]').val())

                // Menghitung total
                var total = jumlah * harga;

                // Menampilkan hasil
                $('input[name=total]').val(formatRupiah(total));
            }

            $('#barang_id').select2({
                theme: 'bootstrap'
            })

            $('#barang_id').on('change', function() {
                let barang_id = $(this).val();

                $.ajax({
                    url: '{{ route('admin.barang.getByIdJson') }}',
                    data: {
                        barang_id
                    },
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.status) {
                            $('input[name=satuan]').val(data.data.satuan.nama);
                            $('input[name=jenis]').val(data.data.jenis.nama);
                            $('input[name=stok]').val(data.data.stok);
                            $('input[name=kode]').val(data.data.kode);
                        }
                    }
                })
            })

            $('input[name=jumlah]').on('input', function() {
                hitungTotal();
            })
            $('input[name=harga]').on('input', function() {
                hitungTotal();
            })
        })
    </script>
@endpush
