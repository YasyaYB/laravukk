<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\barangkeluar;
use App\Models\barangmasuk;
use App\Models\kategori;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $barang = barang::all()->count();
        $kategori = kategori::all()->count();
        $barangmasuk = barangmasuk::all()->count();
        $barangkeluar = barangkeluar::all()->count();
        
        return view('dashboard', compact('barang', 'kategori', 'barangmasuk', 'barangkeluar'));
    }
}