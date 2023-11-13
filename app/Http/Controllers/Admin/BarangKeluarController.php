<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Barang Keluar Index')->only('index');
        $this->middleware('can:Barang Keluar Create')->only(['create', 'store']);
        $this->middleware('can:Barang Keluar Edit')->only(['edit', 'update']);
        $this->middleware('can:Barang Keluar Delete')->only('destroy');
    }

    public function index()
    {
        $barang_id = request('barang_id');
        $supplier_id = request('supplier_id');
        $tanggal = request('tanggal');
        $items = BarangKeluar::latest();
        // filterisasi
        if ($barang_id)
            $items->where('barang_id', $barang_id);
        if ($supplier_id)
            $items->where('supplier_id', $supplier_id);
        if ($tanggal)
            $items->whereDate('created_at', $tanggal);

        $data = $items->get();
        $data_barang = Barang::orderBy('nama', 'ASC')->get();
        return view('admin.pages.barang-keluar.index', [
            'title' => 'Barang Keluar',
            'items' => $data,
            'data_barang' => $data_barang
        ]);
    }

    public function create()
    {
        $data_barang = Barang::orderBy('nama', 'ASC')->get();
        return view('admin.pages.barang-keluar.create', [
            'title' => 'Tambah Barang Keluar',
            'data_barang' => $data_barang
        ]);
    }

    public function store()
    {
        request()->validate([
            'barang_id' => ['required', 'numeric'],
            'jumlah' => ['required', 'min:1', 'numeric']
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['barang_id', 'jumlah', 'keterangan']);
            $barang_keluar = BarangKeluar::create($data);
            $barang_keluar->barang->decrement('stok', request('jumlah'));

            DB::commit();
            return redirect()->route('admin.barang-keluar.index')->with('success', 'Barang Keluar berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = BarangKeluar::with(['barang.satuan', 'barang.jenis'])->FindOrFail($id);
        return view('admin.pages.barang-keluar.edit', [
            'title' => 'Edit Barang Keluar',
            'item' => $item
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'jumlah' => ['required', 'min:1', 'numeric'],
        ]);

        DB::beginTransaction();
        try {
            $item = BarangKeluar::findOrFail($id);
            $data = request()->only(['jumlah', 'keterangan']);
            if ($item->jumlah != request('jumlah')) {
                // udpate juga stok yang ada d barang
                // tambahkan terlebih dahulu dengan stok sebelumnya
                $item->barang->increment('stok', $item->jumlah);
                // tambahkan stok dengan jumlah terbaru
                $item->barang->decrement('stok', request('jumlah'));
            }
            $item->update($data);

            DB::commit();
            return redirect()->route('admin.barang-keluar.index')->with('success', 'Barang Keluar berhasil diupdate.');
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
            $item = BarangKeluar::with('barang')->FindOrFail($id);
            $item->delete();
            // tambahkan stok barang
            $item->barang->increment('stok', $item->jumlah);
            DB::commit();
            return redirect()->route('admin.barang-keluar.index')->with('success', 'Barang Keluar berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
