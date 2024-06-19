@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <a href="{{ route('barangkeluar.create') }}" class="btn btn-md btn-success">TAMBAH BARANG KELUAR</a>
                            <form action="/barangkeluar" method="GET" class="d-flex w-50">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('Gagal'))
                            <div class="alert alert-danger">
                                {{ session('Gagal') }}
                            </div>
                        @endif

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>TANGGAL KELUAR</th>
                                    <th>QTY KELUAR</th>
                                    <th>ID BARANG</th>
                                    <th style="width: 15%">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($barangkeluar as $rowbarangk)
                                    <tr>
                                        <td>{{ $rowbarangk->id }}</td>
                                        <td>{{ $rowbarangk->tgl_keluar }}</td>
                                        <td>{{ $rowbarangk->qty_keluar }}</td>
                                        <td>{{ $rowbarangk->barang_id }}</td>
                                        <td class="text-center">
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('barangkeluar.destroy', $rowbarangk->id) }}" method="POST">
                                                <a href="{{ route('barangkeluar.show', $rowbarangk->id) }}" class="btn btn-sm btn-dark"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('barangkeluar.edit', $rowbarangk->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil-alt"></i></a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Data Barang belum tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{-- {{ $barangkeluar->links() }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
