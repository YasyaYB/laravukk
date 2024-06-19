<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\barang;
use App\Models\kategori;
use App\Models\barangMasuk;
use App\Models\barangKeluar;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $type = $request->input('type');

        if ($type === 'barang') {
            return $this->searchbarang($searchTerm);
        } elseif ($type === 'kategori') {
            return $this->searchkategori($searchTerm);
        } elseif ($type === 'barang_masuk') {
            return $this->searchbarangmasuk($searchTerm);
        } elseif ($type === 'barang_keluar') {
            return $this->searchbarangkeluar($searchTerm);
        } else {
            // Jenis pencarian tidak valid, redirect ke halaman sebelumnya atau berikan pesan kesalahan
            return redirect()->back()->withErrors(['Invalid search type']);
        }
    }

    private function searchbarang($searchTerm)
    {
        $rsetbarang = barang::where('merk', 'like', '%' . $searchTerm . '%')
            ->orWhere('seri', 'like', '%' . $searchTerm . '%')
            ->orWhere('spesifikasi', 'like', '%' . $searchTerm . '%')
            ->orWhere('id', 'like', '%' . $searchTerm . '%')
            ->orWhereHas('kategori', function ($query) use ($searchTerm) {
                $query->where('id', 'like', '%' . $searchTerm . '%');
            })
            ->get();

        return view('v_barang.index', compact('rsetbarang'));
    }

    private function searchkategori($searchTerm)
    {
        $rsetKategori = kategori::where('deskripsi', 'like', '%' . $searchTerm . '%')
            ->orWhere('id', 'like', '%' . $searchTerm . '%')
            ->get();

        return view('v_kategori.index', compact('rsetKategori'));
    }

    private function searchBarangMasuk($searchTerm)
    {
        $rsetBarangMasuk = BarangMasuk::where('tgl_masuk', 'like', '%' . $searchTerm . '%')
            ->orWhere('qty_masuk', 'like', '%' . $searchTerm . '%')
            ->orWhere('id', 'like', '%' . $searchTerm . '%')
            ->orWhereHas('barang', function ($query) use ($searchTerm) {
                $query->where('id', 'like', '%' . $searchTerm . '%');
            })
            ->get();

        return view('v_barangmasuk.index', compact('rsetBarangMasuk'));
    }
    private function searchBarangKeluar($searchTerm)
    {
        $rsetBarangKeluar = BarangKeluar::where('tgl_keluar', 'like', '%' . $searchTerm . '%')
            ->orWhere('qty_keluar', 'like', '%' . $searchTerm . '%')
            ->orWhere('id', 'like', '%' . $searchTerm . '%')
            ->orWhereHas('barang', function ($query) use ($searchTerm) {
                $query->where('id', 'like', '%' . $searchTerm . '%');
            })
            ->get();
    
        return view('v_barangkeluar.index', compact('rsetBarangKeluar'));
    }
    
    
}
