@extends('layout.dash')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card-header">Data Jadwal</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Mata Kuliah</th>
                                <th>Waktu</th>
                                <th>Kuota</th>
                                <th>Sesi</th>
                                <th>Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mahasiswas as $mahasiswa)
                                <tr>
                                    <td>{{ $mahasiswa->tanggal }}</td>
                                    <td>{{ $mahasiswa->nama }}</td>
                                    <td>{{ $mahasiswa->nim }}</td>
                                    <td>{{ $mahasiswa->mata_kuliah }}</td>
                                    <td>{{ $mahasiswa->waktu_mulai }} - {{ $mahasiswa->waktu_selesai }}</td>
                                    <td>{{ $mahasiswa->kuota }}</td>
                                    <td>{{ $mahasiswa->sesi }}</td>
                                    <td>{{ $mahasiswa->kelas }}</td>
                                    <td>
                                        {{-- <a href="{{ route('jadwal.edit', $mahasiswa->id) }}" --}}
                                        class="btn btn-primary btn-sm">Edit</a>
                                        {{-- <form action="{{ route('jadwal.destroy', $mahasiswa->id) }}" method="POST" --}}
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
