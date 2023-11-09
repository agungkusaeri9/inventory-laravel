<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:Supplier Index')->only('index');
        $this->middleware('can:Supplier Create')->only(['create', 'store']);
        $this->middleware('can:Supplier Edit')->only(['edit', 'update']);
        $this->middleware('can:Supplier Delete')->only('destroy');
    }

    public function index()
    {
        $items = Supplier::orderBy('nama', 'ASC')->get();
        return view('admin.pages.supplier.index', [
            'title' => 'Supplier',
            'items' => $items
        ]);
    }

    public function create()
    {
        return view('admin.pages.supplier.create', [
            'title' => 'Tambah Supplier'
        ]);
    }

    public function store()
    {
        request()->validate([
            'nama' => ['required', 'min:5'],
            'email' => ['required', 'unique:supplier,email'],
            'nomor_telepon' => ['required', 'unique:supplier,nomor_telepon'],
            'alamat' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['nama', 'email', 'nomor_telepon', 'nomor_fax', 'alamat']);
            Supplier::create($data);

            DB::commit();
            return redirect()->route('admin.supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = Supplier::FindOrFail($id);
        return view('admin.pages.supplier.edit', [
            'title' => 'Edit Supplier',
            'item' => $item
        ]);
    }

    public function update($id)
    {

        request()->validate([
            'nama' => ['required', 'min:5'],
            'email' => ['required', 'unique:supplier,email,' . $id . ''],
            'nomor_telepon' => ['required', 'unique:supplier,nomor_telepon,' . $id . ''],
            'alamat' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $item = Supplier::findOrFail($id);
            $data = request()->only(['nama', 'email', 'nomor_telepon', 'nomor_fax', 'alamat']);
            $item->update($data);

            DB::commit();
            return redirect()->route('admin.supplier.index')->with('success', 'Supplier berhasil diupdate.');
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
            $item = Supplier::FindOrFail($id);
            $item->delete();
            DB::commit();
            return redirect()->route('admin.supplier.index')->with('success', 'Supplier berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
