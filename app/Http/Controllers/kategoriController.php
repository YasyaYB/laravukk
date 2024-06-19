<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class kategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->search) {
            $rsetKategori = DB::table('kategori')
                            ->select('id', 'deskripsi', DB::raw('kategori'))
                            ->where('id', 'like', '%' . $request->search . '%')
                            ->orWhere('deskripsi', 'like', '%' . $request->search . '%')
                            ->orWhere('kategori', 'like', '%' . $request->search . '%')
                            ->paginate(10);
        } else {
            $rsetKategori = DB::table('kategori')
                            ->select('id', 'deskripsi','kategori')
                            ->paginate(10);
        }
        return view('vkategori.index', compact('rsetKategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vkategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate( [
            'deskripsi'    => 'required',
            'kategori'     => 'required',
        ]);
        kategori::create([
            'deskripsi'     => $request->deskripsi,
            'kategori'      => $request->kategori,
        ]);

        //redirect to index
        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetkategori = kategori::find($id);

        //return $rsetSiswa;

        //return view
        return view('vkategori.show', compact('rsetkategori'));    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $akategori = array('blank'=>'Kategori',
                                    'M'=>'M',
                                    'A'=>'A',
                                    'BPH'=>'BPH',
                                    'BTHP'=>'BTHP'
                        );

        $rsetkategori = kategori::find($id);
        return view('vkategori.edit', compact('rsetkategori','akategori'));

    }

    /**
     * Update the specified resource in storage.
     */
       public function update(Request $request, string $id)
    {
        $request->validate( [
            'deskripsi'    => 'required',
            'kategori'     => 'required',
        ]);

        $rsetkategori = kategori::find($id);

	$rsetkategori->update([
            'deskripsi'    => $request->deskripsi,
            'kategori'     => $request->kategori,
        ]);


        //check if image is uploaded


        //redirect to index
        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Diubah!']);

    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        if (DB::table('barang')->where('kategori_id', $id)->exists()){
            return redirect()->route('kategori.index')->with(['Gagal' => 'Data Gagal Dihapus!']);
        } else {
            $rsetKategori = kategori::find($id);
            $rsetKategori->delete();
            return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Dihapus!']);
        }    }
}
