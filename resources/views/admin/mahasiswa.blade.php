@extends('layout.dash')
@section('content')
    @extends('layout.dash')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Data Mahasiswa</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Mata Kuliah</th>
                                <th>Waktu</th>
                                <th>Sesi</th>
                                <th>Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mahasiswas as $index => $mahasiswa)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($mahasiswa->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                    </td>
                                    <td>{{ $mahasiswa->nama }}</td>
                                    <td>{{ $mahasiswa->nim }}</td>
                                    <td>{{ $mahasiswa->mata_kuliah }}</td>
                                    <td>{{ \Carbon\Carbon::parse($mahasiswa->waktu_mulai)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($mahasiswa->waktu_selesai)->format('H:i') }}</td>
                                    <td>{{ $mahasiswa->sesi }}</td>
                                    <td>{{ $mahasiswa->kelas }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <!-- Tombol Detail -->
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#detailModal{{ $mahasiswa->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $mahasiswa->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="confirmDelete({{ $mahasiswa->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Detail -->
                                <div class="modal fade" id="#detailModal{{ $mahasiswa->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Detail Mahasiswa</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-2">
                                                    <div class="col-md-4">Tanggal</div>
                                                    <div class="col-md-8">:
                                                        {{ \Carbon\Carbon::parse($mahasiswa->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-4">Nama</div>
                                                    <div class="col-md-8">: {{ $mahasiswa->nama }}</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-4">NIM</div>
                                                    <div class="col-md-8">: {{ $mahasiswa->nim }}</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-4">Mata Kuliah</div>
                                                    <div class="col-md-8">: {{ $mahasiswa->mata_kuliah }}</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-4">Waktu</div>
                                                    <div class="col-md-8">:
                                                        {{ \Carbon\Carbon::parse($mahasiswa->waktu_mulai)->format('H:i') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($mahasiswa->waktu_selesai)->format('H:i') }}
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-4">Sesi</div>
                                                    <div class="col-md-8">: {{ $mahasiswa->sesi }}</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-4">Kelas</div>
                                                    <div class="col-md-8">: {{ $mahasiswa->kelas }}</div>
                                                </div>
                                                <div class="row mb-2">
                                                    <div class="col-md-4">Kuota</div>
                                                    <div class="col-md-8">: {{ $mahasiswa->kuota }}</div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk konfirmasi delete -->
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim request delete
                    fetch(`/mahasiswa/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Terhapus!',
                                    data.message,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Gagal!',
                                    data.message,
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            Swal.fire(
                                'Error!',
                                'Terjadi kesalahan saat menghapus data.',
                                'error'
                            );
                        });
                }
            });
        }
    </script>
@endsection
@endsection
