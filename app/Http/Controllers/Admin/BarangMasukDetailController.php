<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BarangMasukDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukDetailController extends Controller
{
    public function edit($uuid)
    {
        $item = BarangMasukDetail::where('uuid', $uuid)->firstOrFail();
        return view('admin.pages.barang-masuk-detail.edit', [
            'title' => 'Edit Barang Masuk Detail',
            'item' => $item
        ]);
    }

    public function destroy($uuid)
    {
        DB::beginTransaction();
        try {
            $item = BarangMasukDetail::where('uuid', $uuid)->firstOrFail();
            $item->barang->decrement('stok', $item->jumlah);
            $item->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Data Barang di barang masuk berhasil dihapus.');
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function update($uuid)
    {
        request()->validate([
            'jumlah' => ['required'],
            'harga' => ['required']
        ]);

        DB::beginTransaction();
        try {
            $item = BarangMasukDetail::where('uuid', $uuid)->firstOrFail();
            $data = request()->only(['jumlah', 'harga']);
            if (request('jumlah') != $item->jumlah || request('harga') != $item->harga) {
                // ada perubahan
                $data['total'] = request('jumlah') * request('harga');

                // kurangi stok sebelumnya, kemudian tambahkan stok baru
                $item->barang->decrement('stok', $item->jumlah);
                $item->barang->increment('stok', request('jumlah'));
            }
            $item->update($data);
            DB::commit();
            return redirect()->route('admin.barang-masuk.show', $item->barang_masuk->uuid)->with('success', 'Data Barang di barang masuk berhasil diupdate.');
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
