<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Validation\Validator;

class BarangMasukController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Barang Masuk Index')->only('index');
        $this->middleware('can:Barang Masuk Create')->only(['create', 'store']);
        $this->middleware('can:Barang Masuk Edit')->only(['edit', 'update']);
        $this->middleware('can:Barang Masuk Delete')->only('destroy');
    }

    public function index()
    {
        $supplier_id = request('supplier_id');
        $tanggal = request('tanggal');
        $items = BarangMasuk::latest();
        // filterisasi
        if ($supplier_id)
            $items->where('supplier_id', $supplier_id);
        if ($tanggal)
            $items->whereDate('created_at', $tanggal);

        $data = $items->get();
        $data_supplier = Supplier::orderBy('nama', 'ASC')->get();
        $data_barang = Barang::orderBy('nama', 'ASC')->get();
        return view('admin.pages.barang-masuk.index', [
            'title' => 'Barang Masuk',
            'items' => $data,
            'data_supplier' => $data_supplier,
            'data_barang' => $data_barang
        ]);
    }

    public function create()
    {
        $data_supplier = Supplier::orderBy('nama', 'ASC')->get();
        $data_barang = Barang::orderBy('nama', 'ASC')->get();
        $data_supplier = Supplier::orderBy('nama', 'ASC')->get();
        return view('admin.pages.barang-masuk.create', [
            'title' => 'Tambah Barang Masuk',
            'data_supplier' => $data_supplier,
            'data_barang' => $data_barang,
            'data_supplier' => $data_supplier
        ]);
    }

    public function store()
    {
        if (request()->ajax()) {
            $validator = FacadesValidator::make(request()->all(), [
                'supplier_id' => ['required', 'numeric'],
                'tanggal' => ['required'],
                'json' => ['required', 'array']
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first()
                ]);
            }
            DB::beginTransaction();
            try {
                $data = request()->only(['supplier_id', 'keterangan', 'tanggal']);
                $data['uuid'] = \Str::uuid();
                $data_json = request('json');
                $data['kode'] = BarangMasuk::getNewCode();
                $barang_masuk = BarangMasuk::create($data);
                foreach ($data_json as $json) {
                    $detail = $barang_masuk->details()->create([
                        'uuid' => \Str::uuid(),
                        'barang_id' => $json[0]['barang_id'],
                        'jumlah' => $json[0]['jumlah'],
                        'harga' => $json[0]['harga'],
                        'total' => $json[0]['jumlah'] * $json[0]['harga']
                    ]);
                    $detail->barang->increment('stok', $json[0]['jumlah']);
                }

                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Barang Masuk berhasil ditambahkan!'
                ]);
            } catch (\Throwable $th) {
                DB::rollBack();
                // throw $th;
                return response()->json([
                    'status' => false,
                    'message' => $th->getMessage()
                ]);
            }
        }
    }

    public function edit($id)
    {
        $item = BarangMasuk::with(['barang.satuan', 'barang.jenis', 'supplier'])->FindOrFail($id);
        return view('admin.pages.barang-masuk.edit', [
            'title' => 'Edit Barang Masuk',
            'item' => $item
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'jumlah' => ['required', 'min:1', 'numeric'],
            'harga' => ['required', 'numeric', 'min:1'],
        ]);

        DB::beginTransaction();
        try {
            $item = BarangMasuk::findOrFail($id);
            $data = request()->only(['jumlah', 'harga', 'keterangan']);
            if ($item->jumlah != request('jumlah') || $item->harga != $item->harga) {
                // jika jumlah atau harga berubah
                $data['total'] = request('jumlah') * request('harga');

                // udpate juga stok yang ada d barang
                // kurangi terlebih dahulu dengan stok sebelumnya
                $item->barang->decrement('stok', $item->jumlah);
                // tambahkan stok dengan jumlah terbaru
                $item->barang->increment('stok', request('jumlah'));
            }
            $item->update($data);

            DB::commit();
            return redirect()->route('admin.barang-masuk.index')->with('success', 'Barang Masuk berhasil diupdate.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy($uuid)
    {

        DB::beginTransaction();
        try {
            $item = BarangMasuk::with('details.barang')->where('uuid', $uuid)->firstOrFail();
            foreach ($item->details as $detail) {
                // kurangi stok barang
                $detail->barang->decrement('stok', $detail->jumlah);
            }
            $item->delete();
            DB::commit();
            return redirect()->route('admin.barang-masuk.index')->with('success', 'Barang Masuk berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function show($uuid)
    {
        $item = BarangMasuk::with('details.barang')->where('uuid', $uuid)->firstOrFail();
        return view('admin.pages.barang-masuk.show', [
            'title' => 'Detail Barang Masuk',
            'item' => $item
        ]);
    }
}
