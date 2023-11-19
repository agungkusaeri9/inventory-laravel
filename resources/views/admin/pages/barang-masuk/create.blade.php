@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Pilih Barang</h4>
                    <form action="javascript:void(0)" method="post">
                        @csrf
                        <input type="text" name="nama_barang" hidden>
                        <div class='form-group mb-3'>
                            <label for='barang_id' class='mb-2'>Barang</label>
                            <select name="barang_id" id="barang_id"
                                class="form-control @error('barang_id') is-invalid @enderror">
                                <option value="" selected>Pilih Barang</option>
                                @foreach ($data_barang as $barang)
                                    <option value="{{ $barang->id }}">{{ $barang->nama }}</option>
                                @endforeach
                            </select>
                            @error('barang_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3 row'>
                            <div class="col-md-6">
                                <label for='kode' class='mb-2'>Kode</label>
                                <input type='text' name='kode'
                                    class='form-control @error('kode') is-invalid @enderror' value='{{ old('kode') }}'
                                    readonly>
                                @error('kode')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for='jenis' class='mb-2'>Jenis</label>
                                <input type='text' name='jenis'
                                    class='form-control @error('jenis') is-invalid @enderror' value='{{ old('jenis') }}'
                                    readonly>
                                @error('jenis')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class='form-group mb-3 row'>
                            <div class="col-md">
                                <label for='satuan' class='mb-2'>Satuan</label>
                                <input type='text' name='satuan'
                                    class='form-control @error('satuan') is-invalid @enderror' value='{{ old('satuan') }}'
                                    readonly>
                                @error('satuan')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md">
                                <label for='stok' class='mb-2'>Stok Tersedia</label>
                                <input type='text' name='stok'
                                    class='form-control @error('stok') is-invalid @enderror' value='{{ old('stok') }}'
                                    readonly>
                                @error('stok')
                                    <div class='invalid-feedback'>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class='form-group mb-3'>
                            <label for='jumlah' class='mb-2'>Jumlah</label>
                            <input type='number' name='jumlah' class='form-control @error('jumlah') is-invalid @enderror'
                                value='{{ old('jumlah') }}'>
                            @error('jumlah')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='harga' class='mb-2'>Harga</label>
                            <input type='number' name='harga' class='form-control @error('harga') is-invalid @enderror'
                                value='{{ old('harga') }}'>
                            @error('harga')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-info text-white btnTambahBarang btn-block" type="button">Tambah
                                Barang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Data Barang</h4>
                    <table class="table listBarang table-bordered">
                        <thead>
                            <tr>
                                <th class="text-left">Nama Barang</th>
                                <th class="text-left">Kode</th>
                                <th class="text-center">Jumlah Masuk</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Total Harga</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-body">
                    <form action="javascript:void(0)" method="post">
                        <div class='form-group mb-3'>
                            <label for='supplier_id' class='mb-2'>Supplier</label>
                            <select name="supplier_id" id="supplier_id"
                                class="form-control select2 @error('supplier_id') is-invalid @enderror">
                                <option value="" selected disabled>Pilih Supplier</option>
                                @foreach ($data_supplier as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='keterangan' class='mb-2'>Keterangan</label>
                            <textarea name='keterangan' id='keterangan' cols='30' rows='3'
                                class='form-control @error('keterangan') is-invalid @enderror'>{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tanggal' class='mb-2'>Tanggal</label>
                            <input type='date' name='tanggal'
                                class='form-control @error('tanggal') is-invalid @enderror' value='{{ old('tanggal') }}'>
                            @error('tanggal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary float-right btnSimpanBarangMasuk">Simpan Barang Masuk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Datatable />
<x-Admin.Sweetalert />
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@push('scripts')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <script>
        $(function() {
            $('.select2').select2({
                theme: 'bootstrap'
            })
            let oTable = $('.listBarang').DataTable({
                columnDefs: [{
                    targets: -1, // Mengarahkan ke kolom terakhir (kolom aksi)
                    data: null,
                    defaultContent: "<button class='btn btn-sm btn-danger hapusButton'>Hapus</button>",
                }],
            });

            function formatRupiah(inputAngka) {
                let rupiah = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(inputAngka);
                return rupiah;
            }

            function hitungTotal() {
                // Mengambil nilai dari kedua input
                let jumlah = parseInt($('input[name=jumlah]').val())
                let harga = parseInt($('input[name=harga]').val())

                // Menghitung total
                let total = jumlah * harga;

                return total;

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
                            $('input[name=nama_barang]').val(data.data.nama);
                            $('input[name=satuan]').val(data.data.satuan.nama);
                            $('input[name=jenis]').val(data.data.jenis.nama);
                            $('input[name=stok]').val(data.data.stok);
                            $('input[name=kode]').val(data.data.kode);
                        }
                    }
                })
            })

            $('.btnTambahBarang').on('click', function() {
                let dataArray = [];
                let nama_barang = $("input[name=nama_barang]").val();
                let barang_id = $("select[name=barang_id]").val();
                let kode = $("input[name=kode]").val();
                let jumlah = $("input[name=jumlah]").val();
                let harga = $("input[name=harga]").val();
                let total = hitungTotal();
                dataArray.push({
                    barang_id,
                    nama_barang,
                    kode,
                    jumlah,
                    harga,
                    total
                });
                tambahkanDataBaruLocalStorage(dataArray, "list_barang_masuk");
                $('form').trigger('reset');
            })

            function tambahkanDataBaruLocalStorage(dataArray, key) {
                try {
                    // Ambil data yang sudah ada (jika ada)
                    let existingData = localStorage.getItem(key);

                    if (existingData !== null) {
                        // Jika sudah ada data, parse dari JSON ke array
                        let existingArray = JSON.parse(existingData);

                        // Tambahkan data baru ke array
                        existingArray.push(dataArray);

                        // Simpan array yang diperbarui ke localStorage
                        localStorage.setItem(key, JSON.stringify(existingArray));
                    } else {
                        // Jika tidak ada data sebelumnya, buat array baru
                        let newArray = [dataArray];
                        localStorage.setItem(key, JSON.stringify(newArray));
                    }

                    tampilkanData(key);
                } catch (error) {
                    console.error("Terjadi kesalahan:", error);
                }
            }

            function tampilkanData(key) {
                try {
                    let table = $('.listBarang').DataTable();
                    let storedData = localStorage.getItem(key);

                    if (storedData) {
                        let retrievedData = JSON.parse(storedData);

                        // Inisialisasi DataTable
                        table.clear();

                        if (retrievedData.length > 0) {
                            // Jika ada data, tambahkan data ke DataTable
                            retrievedData.forEach(function(data) {
                                let data2 = data[0];
                                table.row.add([
                                    data2.nama_barang,
                                    data2.kode,
                                    data2.jumlah,
                                    formatRupiah(data2.harga),
                                    formatRupiah(data2.total)
                                ]).draw();
                            });
                        }
                    } else {
                        // Jika tidak ada data yang disimpan di localStorage, tambahkan baris kosong ke DataTable
                        console.log("Tidak ada data yang disimpan di localStorage.");
                    }
                } catch (error) {
                    console.error("Terjadi kesalahan:", error);
                }
            }

            function hapusData(data, key) {
                try {
                    let storedData = localStorage.getItem(key);

                    if (storedData) {
                        let retrievedData = JSON.parse(storedData);

                        // Cari indeks data berdasarkan data yang diklik
                        let index = retrievedData.findIndex(function(d) {
                            return d[0].nama_barang === data[0];
                        });
                        if (index !== -1) {
                            // Hapus data dari array
                            retrievedData.splice(index, 1);
                            localStorage.setItem(key, JSON.stringify(retrievedData));
                            console.log("Data berhasil dihapus.");
                            if (index == 0) {
                                let table = $('.listBarang').DataTable();
                                table.clear().draw();
                            }
                        } else {
                            console.log("Data tidak ditemukan.");
                        }

                        // Tampilkan data terbaru
                        tampilkanData(key);
                    } else {
                        console.log("Tidak ada data yang disimpan di localStorage.");
                    }
                } catch (error) {
                    console.error("Terjadi kesalahan:", error);
                }
            }
            $('.listBarang tbody').on('click', 'button.hapusButton', function() {
                let data = $('.listBarang').DataTable().row($(this).parents('tr')).data();
                hapusData(data, "list_barang_masuk");
            });
            tampilkanData("list_barang_masuk");

            $('.btnSimpanBarangMasuk').on('click', function() {
                let json = JSON.parse(localStorage.getItem('list_barang_masuk'));
                let supplier_id = $('select[name=supplier_id]').val();
                let keterangan = $('textarea[name=keterangan]').val();
                let tanggal = $('input[name=tanggal]').val();
                //    insert data simpanan masuk
                $.ajax({
                    url: '{{ route('admin.barang-masuk.store') }}',
                    data: {
                        json,
                        supplier_id,
                        keterangan,
                        tanggal
                    },
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.status) {
                            sweetalert("success", response.message);
                            // hapus data di localstorage
                            localStorage.removeItem("list_barang_masuk");
                            setInterval(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            sweetalert("error", response.message);
                        }

                    }
                })
            })

            function sweetalert(type, message) {
                if (type === 'success') {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Berhasil!',
                        text: message,
                        showConfirmButton: true,
                        timer: 1500
                    })
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Gagal!',
                        text: message,
                        showConfirmButton: true,
                        timer: 1500
                    })
                }
            }
        })
    </script>
@endpush
