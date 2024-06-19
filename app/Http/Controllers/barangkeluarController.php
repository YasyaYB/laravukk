<?php

namespace App\Http\Controllers;

use App\Models\barangkeluar;
use App\Models\barang;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class barangkeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');

        if ($searchTerm) {
            $barangkeluar = barangkeluar::where('tgl_keluar', 'like', '%' . $searchTerm . '%')
                ->orWhere('qty_keluar', 'like', '%' . $searchTerm . '%')
                ->orWhere('id', 'like', '%' . $searchTerm . '%')
                ->orWhereHas('barang', function ($query) use ($searchTerm) {
                    $query->where('id', 'like', '%' . $searchTerm . '%');
                })
                ->get();
        } else {
            $barangkeluar = barangkeluar::all();
        }

        return view('vbarangkeluar.index', compact('barangkeluar'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangid = barang::all();
        return view('vbarangkeluar.create', compact('barangid'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tgl_keluar' => 'required|date',
            'qty_keluar' => [
                'required',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    $barang = barang::findOrFail($request->barang_id);
                    $stok_barang = $barang->stok;
    
                    if ($value > $stok_barang) {
                        $fail("Kuantitas tidak boleh melebihi stok ($stok_barang)");
                    }
                    else {
                        // Simpan data barang keluar hanya jika kuantitas valid
                        barangkeluar::create([
                            'tgl_keluar' => $request->tgl_keluar,
                            'qty_keluar' => $value,
                            'barang_id' => $request->barang_id,
                        ]);
                        $barang->stok -= $value;
                        $barang->save();
                    }
                },
            ],
            'barang_id' => 'required|exists:barang,id',
        ]);

        //redirect to index
        return redirect()->route('barangkeluar.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetbarangkeluar = barangkeluar::find($id);

        //return $rsetSiswa;

        //return view
        return view('vbarangkeluar.show', compact('rsetbarangkeluar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       $rsetbarangkeluar = barangkeluar::find($id);
        return view('vbarangkeluar.edit', compact('rsetbarangkeluar'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $request->validate( [
            'tgl_keluar'    => 'required',
            'qty_keluar'     => 'required',
            'barang_id'  => 'required',
        ]);

        $rsetbarangkeluar= barangkeluar::find($id);

        $rsetbarangkeluar->update([
            'tgl_keluar'    => $request->tgl_keluar,
            'qty_keluar'     => $request->qty_keluar,
            'barang_id'  => $request->barang_id,
        ]);

	 return redirect()->route('barangkeluar.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            $rsetbarangkeluar= barangkeluar::find($id);
            $rsetbarangkeluar->delete();
            return redirect()->route('barangkeluar.index')->with(['success' => 'Data Berhasil Dihapus!']);
    
	}
}
