<?php

namespace App\Http\Controllers;

use App\Models\barangmasuk;
use App\Models\barang;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;


class barangmasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');

        if ($searchTerm) {
            $barangmasuk = barangmasuk::where('tgl_masuk', 'like', '%' . $searchTerm . '%')
                ->orWhere('qty_masuk', 'like', '%' . $searchTerm . '%')
                ->orWhere('id', 'like', '%' . $searchTerm . '%')
                ->orWhereHas('barang', function ($query) use ($searchTerm) {
                    $query->where('id', 'like', '%' . $searchTerm . '%');
                })
                ->get();
        } else {
            $barangmasuk = barangmasuk::all();
        }

        return view('vbarangmasuk.index', compact('barangmasuk'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangmasuk = barang::all();
        return view('vbarangmasuk.create', compact('barangmasuk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate( [
            'tgl_masuk'    => 'required|date',
            'qty_masuk'     => 'required',
            'barang_id'  => 'required',
        ]);
        barangmasuk::create([
            'tgl_masuk'    => $request->tgl_masuk,
            'qty_masuk'     =>  $request->qty_masuk,
            'barang_id'  =>  $request->barang_id,
        ]);

        //redirect to index
        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetbarangmasuk = barangmasuk::find($id);

        //return $rsetSiswa;

        //return view
        return view('vbarangmasuk.show', compact('rsetbarangmasuk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       $rsetbarangmasuk = barangmasuk::find($id);
        return view('vbarangmasuk.edit', compact('rsetbarangmasuk'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $request->validate( [
            'tgl_masuk'    => 'required',
            'qty_masuk'     => 'required',
            'barang_id'  => 'required',
        ]);

        $rsetbarangmasuk = barangmasuk::find($id);

        $rsetbarangmasuk->update([
            'tgl_masuk'    => $request->tgl_masuk,
            'qty_masuk'     => $request->qty_masuk,
            'barang_id'  => $request->barang_id,
        ]);

	 return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        $rsetbarangmasuk = barangmasuk::find($id);
        
        // Memeriksa apakah ada record di tabel BarangKeluar dengan barang_id yang sama
        $referencedInBarangKeluar = barangkeluar::where('barang_id', $rsetbarangmasuk->barang_id)->exists();

        if ($referencedInBarangKeluar) {
        // Jika ada referensi, penghapusan ditolak
        return redirect()->route('vbarangmasuk.index')->with(['error' => 'Data Tidak Bisa Dihapus Karena Masih Digunakan di Tabel Barang dan Barang Keluar!']);
        }

        // Menghapus record di tabel BarangMasuk
        $rsetbarangmasuk->delete();

        // Redirect ke index dengan pesan sukses
        return redirect()->route('vbarangmasuk.index')->with(['success' => 'Data Berhasil Dihapus!']);
	}
}
