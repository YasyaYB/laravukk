@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
               <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>MERK</td>
                                <td>{{ $rsetbarang->merk}}</td>
                            </tr>
                            <tr>
                                <td>SERI</td>
                                <td>{{ $rsetbarang->seri }}</td>
                            </tr>
                            <tr>
                                <td>SPESIFIKASI</td>
                                <td>{{ $rsetbarang->spesifikasi }}</td>
                            </tr>
                            <tr>
                                <td>STOK</td>
                                <td>{{ $rsetbarang->stok }}</td>
                            </tr>
                            <tr>
                                <td>KATEGORI ID</td>
                                <td>{{ $rsetbarang->kategori_id }}</td>
                            </tr>

                        </table>
                    </div>
               </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12  text-center">
                

                <a href="{{ route('barang.index') }}" class="btn btn-md btn-primary mb-3">Back</a>
            </div>
        </div>
    </div>
@endsection