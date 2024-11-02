@extends('layout.dash')

@section('content')
    <style>
        .btn-danger {
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            transition: all 0.15s ease-in-out;
        }

        .btn-danger:hover {
            opacity: 0.85;
            transform: translateY(-1px);
        }
    </style>
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
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Mata Kuliah</th>
                                <th>Tanggal</th>
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
                                    <td>{{ $mahasiswa->nama }}</td>
                                    <td>{{ $mahasiswa->nim }}</td>
                                    <td>{{ $mahasiswa->mata_kuliah }}</td>
                                    <td>{{ \Carbon\Carbon::parse($mahasiswa->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($mahasiswa->waktu_mulai)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($mahasiswa->waktu_selesai)->format('H:i') }}</td>
                                    <td>{{ $mahasiswa->sesi }}</td>
                                    <td>{{ $mahasiswa->kelas }}</td>
                                    <td>
                                        <!-- <small class="text-muted">ID: {{ $mahasiswa->id }}</small> -->

                                        <button type="button" class="btn btn-danger btn-sm" data-id="{{ $mahasiswa->id }}"
                                            onclick="deleteMahasiswa({{ $mahasiswa->id }})">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">Tidak ada data mahasiswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function checkData(id) {
            console.log({
                'ID Type': typeof id,
                'ID Value': id,
                'Route': `/mahasiswa/${id}`,
                'CSRF Token': document.querySelector('meta[name="csrf-token"]').content
            });
        }

        function deleteMahasiswa(id) {
            checkData(id);
            console.log('ID yang diterima:', id);

            // Validasi ID
            if (!id || id === 'undefined' || id === '') {
                Swal.fire('Error!', 'ID mahasiswa tidak valid', 'error');
                return;
            }

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
                    // Debug log
                    console.log('Mengirim request delete untuk ID:', id);

                    fetch(`/mahasiswa/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            // Debug log
                            console.log('Response status:', response.status);
                            return response.json();
                        })
                        .then(data => {
                            // Debug log
                            console.log('Response data:', data);

                            if (data.success) {
                                Swal.fire(
                                    'Terhapus!',
                                    data.message,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                throw new Error(data.message || 'Gagal menghapus data');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                error.message || 'Terjadi kesalahan saat menghapus data.',
                                'error'
                            );
                        });
                }
            });
        }
    </script>
@endsection
