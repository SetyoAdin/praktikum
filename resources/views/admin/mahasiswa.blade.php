@extends('layout.dash')
@section('content')
    <div class="table-card">
        <h3 class="card-title">Daftar Mata Kuliah</h3>

        <!-- Button untuk Membuka Modal -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#updateRuanganModal">
            Tambah Ruangan dan Penanggung Jawab
        </button>

        <div class="table-responsive">
            <table id="mataKuliahTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Kelas</th>
                        <th>Tanggal</th>
                        <th>Mata Kuliah</th>
                        <th>Sesi</th>
                        <th>Waktu</th>
                        <th>Ruangan</th>
                        <th>Penanggung Jawab</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mahasiswas as $mahasiswa)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $mahasiswa->nama }}</td>
                            <td>{{ $mahasiswa->nim }}</td>
                            <td>{{ $mahasiswa->kelas }}</td>
                            <td>{{ \Carbon\Carbon::parse($mahasiswa->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                            </td>
                            <td>{{ $mahasiswa->mata_kuliah }}</td>
                            <td>{{ $mahasiswa->sesi }}</td>
                            <td>{{ \Carbon\Carbon::parse($mahasiswa->waktu_mulai)->format('H:i') }}-{{ \Carbon\Carbon::parse($mahasiswa->waktu_selesai)->format('H:i') }}
                            </td>
                            <td>{{ $mahasiswa->ruangan }}</td>
                            <td>{{ $mahasiswa->penanggung_jawab }}</td>
                            <td>
                                <a href="#" class="icon-button"
                                    onclick="confirmDelete('{{ $mahasiswa->id }}', '{{ $mahasiswa->id_jadwal }}')">
                                    <i class="fas fa-trash-alt delete-icon"></i>
                                </a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="updateRuanganModal" tabindex="-1" aria-labelledby="updateRuanganModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('mahasiswa.updateRuangan') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateRuanganModalLabel">Tambah Ruangan dan Penanggung Jawab</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Pilih Mahasiswa -->
                        <div class="mb-3">
                            <label for="mahasiswa_id" class="form-label">Pilih Mahasiswa</label>
                            <select name="mahasiswa_id" id="mahasiswa_id" class="form-control" required>
                                <option value="">Pilih Mahasiswa</option>
                                @foreach ($mahasiswas as $mahasiswa)
                                    <option value="{{ $mahasiswa->id }}">{{ $mahasiswa->nama }} - {{ $mahasiswa->nim }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Input Ruangan -->
                        <div class="mb-3">
                            <label for="ruangan" class="form-label">Ruangan</label>
                            <input type="text" class="form-control" id="ruangan" name="ruangan" required>
                        </div>

                        <!-- Input Penanggung Jawab -->
                        <div class="mb-3">
                            <label for="penanggung_jawab" class="form-label">Penanggung Jawab</label>
                            <input type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(mahasiswaId, jadwalId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan hapus ke server
                    deleteMahasiswa(mahasiswaId, jadwalId);
                }
            });
        }

        function deleteMahasiswa(mahasiswaId, jadwalId) {
            fetch(`/mahasiswa/delete/${mahasiswaId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    jadwalId: jadwalId
                })
            }).then(response => {
                if (response.ok) {
                    Swal.fire(
                        'Terhapus!',
                        'Data berhasil dihapus.',
                        'success'
                    ).then(() => {
                        location.reload(); // Refresh halaman setelah berhasil dihapus
                    });
                } else {
                    Swal.fire(
                        'Gagal!',
                        'Data gagal dihapus.',
                        'error'
                    );
                }
            });
        }
    </script>
@endsection
