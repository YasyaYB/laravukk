@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('barang.create') }}" class="btn btn-md btn-success">TAMBAH BARANG</a>
                            <div class="row mb-3 w-50">
                                <div class="col-md-12 ml-auto">
                                    <form action="{{ route('barang.index') }}" method="GET">
                                        @csrf
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control" placeholder="Search for ..." value="{{ request()->query('search') }}">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-outline-secondary">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('Success'))
                    <div class="alert alert-success">
                        {{ session('Success') }}
                    </div>
                @endif

                @if(session('Gagal'))
                    <div class="alert alert-danger">
                        {{ session('Gagal') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>MERK</th>
                                    <th>SERI</th>
                                    <th>SPESIFIKASI</th>
                                    <th>STOK</th>
                                    <th>KATEGORI_ID</th>
                                    <th style="width: 15%">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rsetBarang as $rowbarang)
                                    <tr>
                                        <td>{{ $rowbarang->id }}</td>
                                        <td>{{ $rowbarang->merk }}</td>
                                        <td>{{ $rowbarang->seri }}</td>
                                        <td>{{ $rowbarang->spesifikasi }}</td>
                                        <td>{{ $rowbarang->stok }}</td>
                                        <td>{{ $rowbarang->kategori_id }}</td>
                                        <td class="text-center">
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('barang.destroy', $rowbarang->id) }}" method="POST">
                                                <a href="{{ route('barang.show', $rowbarang->id) }}" class="btn btn-sm btn-dark"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('barang.edit', $rowbarang->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil-alt"></i></a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Data Barang belum tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        setTimeout(function(){
            document.querySelectorAll('.alert').forEach(function(alert){
                alert.style.display = 'none';
            });
        }, 2000);
    </script>
@endsection
