@extends('layouts.app')

@section('title', 'Data Pembeli')

@section('content')
    <h2>Data Pembeli</h2>
    <a href="{{ route('buyers.create') }}" class="btn btn-primary mb-3">Tambah Pembeli</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No HP</th>
            </tr>
        </thead>
        <tbody>
            @foreach($buyers as $buyer)
                <tr>
                    <td>{{ $buyer->id }}</td>
                    <td>{{ $buyer->nama }}</td>
                    <td>{{ $buyer->alamat }}</td>
                    <td>{{ $buyer->no_hp }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
