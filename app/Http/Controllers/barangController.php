<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\kategori;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class barangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');

        if ($searchTerm) {
            $rsetBarang = barang::where('id', 'like', '%' . $searchTerm . '%')
                ->orWhere('merk', 'like', '%' . $searchTerm . '%')
                ->orWhere('seri', 'like', '%' . $searchTerm . '%')
                ->orWhere('spesifikasi', 'like', '%' . $searchTerm . '%')
                ->orWhere('stok', 'like', '%' . $searchTerm . '%')
                ->orWhereHas('kategori', function ($query) use ($searchTerm) {
                    $query->where('kategori_id', 'like', '%' . $searchTerm . '%');
                })
                ->get();
        } else {
            $rsetBarang = barang::all();
        }
    
            // $barang = $query->paginate(10);
            return view('vbarang.index', compact('rsetBarang'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = kategori::all(); // Fetch all categories from the database
        return view('vbarang.create', compact('kategoris'));    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate( [
            'merk'    => 'required',
            'seri'     => 'required',
            'spesifikasi'  => 'required',
            'stok'   => 'required',
            'kategori_id'  => 'required',
        ]);
        barang::create([
            'merk'     => $request->merk,
            'seri'      => $request->seri,
            'spesifikasi'   => $request->spesifikasi,
            'stok'    => $request->stok,
            'kategori_id'   => $request->kategori_id,
        ]);

        //redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetbarang = barang::find($id);

        //return $rsetSiswa;

        //return view
        return view('vbarang.show', compact('rsetbarang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $rsetbarang = barang::find($id);
        return view('vbarang.edit', compact('rsetbarang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate( [
            'merk'    => 'required',
            'seri'     => 'required',
            'spesifikasi'  => 'required',
            'stok'   => 'required',
            'kategori_id'  => 'required',
        ]);

        $rsetbarang = barang::find($id);

        $rsetbarang->update([
            'merk'    => $request->merk,
            'seri'     => $request->seri,
            'spesifikasi'  => $request->spesifikasi,
            'stok'   => $request->stok,
            'kategori_id'  => $request->kategori_id,
        ]);

        //redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Diubah!']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (DB::table('barangmasuk')->where('barang_id', $id)->exists() || DB::table('barangkeluar')->where('barang_id', $id)->exists()){
            return redirect()->route('barang.index')->with(['Gagal' => 'Data Gagal Dihapus!']);
        } else {
            $rsetKategori = barang::find($id);
            $rsetKategori->delete();
            return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Dihapus!']);
        }
	
    }
}
