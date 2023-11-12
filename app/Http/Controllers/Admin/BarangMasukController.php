<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;

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
        $items = BarangMasuk::latest()->get();
        return view('admin.pages.barang-masuk.index', [
            'title' => 'Barang Masuk',
            'items' => $items
        ]);
    }

    public function create()
    {
        return view('admin.pages.barang-masuk.create', [
            'title' => 'Tambah Barang Masuk'
        ]);
    }

    public function store()
    {
        request()->validate([
            'nama' => ['required', 'unique:Barang Masuk,nama'],
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['nama']);
            BarangMasuk::create($data);

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
        $item = BarangMasuk::FindOrFail($id);
        return view('admin.pages.barang-masuk.edit', [
            'title' => 'Edit Barang Masuk',
            'item' => $item
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'nama' => ['required', 'unique:Barang Masuk,nama,' . $id . ''],
        ]);

        DB::beginTransaction();
        try {
            $item = BarangMasuk::findOrFail($id);
            $data = request()->only(['nama']);
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
            $item = BarangMasuk::FindOrFail($id);
            $item->delete();
            DB::commit();
            return redirect()->route('admin.barang-masuk.index')->with('success', 'Barang Masuk berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
