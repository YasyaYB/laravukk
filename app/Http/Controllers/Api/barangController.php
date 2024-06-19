<?php

namespace App\Http\Controllers\Api;

//import model Post
use App\Models\barang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;





//import resource PostResource
use App\Http\Resources\barangResource;

class barangController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $posts = barang::latest()->paginate(5);

        //return collection of posts as a resource
        return new barangResource(true, 'List Data Barang', $posts);
    }

        /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $request->validate([
            'merk'    => 'required',
            'seri'     => 'required',
            'spesifikasi'  => 'required',
            'stok'   => 'required',
            'kategori_id'  => 'required',
        ]);

        //check if validation fails
        if (!$request->all()) {
            return response()->json($request->errors(), 422);
        }

        //create post
        $barang = barang::create([
            'merk'     => $request->merk,
            'seri'      => $request->seri,
            'spesifikasi'   => $request->spesifikasi,
            'stok'    => $request->stok,
            'kategori_id'   => $request->kategori_id,        ]);

        //return response
        return new barangResource(true, 'Data Barang Berhasil Ditambahkan!', $barang);
    }

        /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id)
    {
        //find post by ID
        $barang = barang::find($id);

        //return single post as a resource
        return new barangResource(true, 'Detail Data Post!', $barang);
    }

        /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        //define validation rules
        $barang = barang::find($id);

        if (is_null($barang)) {
            return response()->json(['status' => 'Barang tidak ditemukan'], 404);
        }

        try {
            $barang->update($request->all());
            return response()->json(['status' => 'Barang berhasil diubah'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'Gagal mengubah barang'], 500);
        }

        //return response
        return new PostResource(true, 'Data Post Berhasil Diubah!', $post);
    }

    public function destroy(string $id)
    {
        $barang = barang::find($id);

        if (is_null($barang)) {
            return response()->json(['status' => 'Barang tidak ditemukan'], 404);
        }

        try {
            $barang->delete();
            return response()->json(['status' => 'Barang berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'Barang tidak dapat dihapus'], 500);
        }
    }

}