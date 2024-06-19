<?php

namespace App\Http\Controllers\Api;

//import model Post
use App\Models\kategori;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;





//import resource PostResource
use App\Http\Resources\kategoriResource;

class kategoriController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $kategori = kategori::latest()->get();

        //return collection of posts as a resource
        return new kategoriResource(true, 'List Data Kategori', $kategori);
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
            'deskripsi'    => 'required',
            'kategori'     => 'required',
        ]);

        //check if validation fails
        if (!$request->all()) {
            return response()->json($request->errors(), 422);
        }

        //create post
        $barang = kategori::create([
            'deskripsi'     => $request->deskripsi,
            'kategori'      => $request->kategori,
        ]);

        //return response
        return new kategoriResource(true, 'Data Kategori Berhasil Ditambahkan!', $barang);
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
        $barang = kategori::find($id);

        //return single post as a resource
        return new kategoriResource(true, 'Detail Data Kategori!', $barang);
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
        $kategori = kategori::find($id);

        if (is_null($kategori)) {
            return response()->json(['status' => 'Kategori tidak ditemukan'], 404);
        }

        try {
            $kategori->update($request->all());
            return response()->json(['status' => 'Kategori berhasil diubah'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'Gagal mengubah kategori'], 500);
        }
    }

    public function destroy(string $id)
    {
        $kategori = kategori::find($id);

        if (is_null($kategori)) {
            return response()->json(['status' => 'Kategori tidak ditemukan'], 404);
        }

        try {
            $kategori->delete();
            return response()->json(['status' => 'Kategori berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'Kategori tidak dapat dihapus'], 500);
        }
    }

}