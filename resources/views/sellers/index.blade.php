@extends('layouts.app')

@section('title', 'Data Penjual')

@section('content')
    <h2>Data Penjual</h2>
    <a href="{{ route('sellers.create') }}" class="btn btn-primary mb-3">Tambah Penjual</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Koperasi</th>
                <th>Kecamatan</th>
                <th>Desa/Kelurahan</th>
                <th>Jenis Usaha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sellers as $seller)
                <tr>
                    <td>{{ $seller->id }}</td>
                    <td>{{ $seller->nama_koperasi }}</td>
                    <td>{{ $seller->kecamatan }}</td>
                    <td>{{ $seller->desa_kelurahan }}</td>
                    <td>{{ $seller->jenis_usaha }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
