@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
               <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>TANGGAL KELUAR</td>
                                <td>{{ $rsetbarangkeluar->tgl_keluar}}</td>
                            </tr>
                            <tr>
                                <td>QTY KELUAR</td>
                                <td>{{ $rsetbarangkeluar->qty_keluar }}</td>
                            </tr>
                            <tr>
                                <td>ID BARANG</td>
                                <td>{{ $rsetbarangkeluar->barang_id }}</td>
                            </tr>
                        </table>
                    </div>
               </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12  text-center">
                

                <a href="{{ route('barangkeluar.index') }}" class="btn btn-md btn-primary mb-3">Back</a>
            </div>
        </div>
    </div>
@endsection