<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $barang_id = request('barang_id');
        $supplier_id = request('supplier_id');
        $tanggal = request('tanggal');
        $items = BarangMasuk::latest();
        // filterisasi
        if ($barang_id)
            $items->where('barang_id', $barang_id);
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
        return view('admin.pages.barang-masuk.create', [
            'title' => 'Tambah Barang Masuk',
            'data_supplier' => $data_supplier,
            'data_barang' => $data_barang
        ]);
    }

    public function store()
    {
        request()->validate([
            'barang_id' => ['required', 'numeric'],
            'supplier_id' => ['required', 'numeric'],
            'jumlah' => ['required', 'min:1', 'numeric'],
            'harga' => ['required', 'numeric', 'min:1'],
            'total' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['barang_id', 'supplier_id', 'jumlah', 'harga', 'keterangan']);
            $data['total'] = request('jumlah') * request('harga');
            $barang_masuk = BarangMasuk::create($data);
            $barang_masuk->barang->increment('stok', request('jumlah'));

            DB::commit();
            return redirect()->route('admin.barang-masuk.index')->with('success', 'Barang Masuk berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
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
            $data = request()->only(['jumlah', 'harga']);
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

    public function destroy($id)
    {

        DB::beginTransaction();
        try {
            $item = BarangMasuk::with('barang')->FindOrFail($id);
            $item->delete();
            // kurangi stok barang
            $item->barang->decrement('stok', $item->jumlah);
            DB::commit();
            return redirect()->route('admin.barang-masuk.index')->with('success', 'Barang Masuk berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
