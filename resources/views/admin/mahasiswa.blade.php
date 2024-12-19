@extends('layout.dash')
@section('content')
    <style>
        /* Search Bar Styling */
        .dataTables_wrapper .dataTables_filter {
            text-align: right;
            margin-bottom: 10px;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px 10px;
            outline: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #2c3e50;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        }

        /* Show Entries Styling */
        .dataTables_wrapper .dataTables_length {
            margin-bottom: 10px;
            font-size: 14px;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            outline: none;
            transition: all 0.3s ease;
        }

        .dataTables_wrapper .dataTables_length select:focus {
            border-color: #2c3e50;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        }

        /* Pagination Styling */
        .dataTables_wrapper .dataTables_paginate {
            text-align: right;
            margin-top: 10px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px 10px;
            margin: 0 2px;
            color: #2c3e50;
            background-color: #fff;
            transition: all 0.3s ease;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: #fff;
            background-color: #2c3e50;
            border-color: #2c3e50;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #2c3e50;
            color: #fff !important;
            border-color: #2c3e50;
        }
    </style>
    <div class="table-card">
        <h3 class="card-title">Daftar Mata Kuliah</h3>

        <!-- Button untuk Membuka Modal -->
        <button type="button" class="btn btn-custom mb-3" data-bs-toggle="modal" data-bs-target="#updateRuanganModal">
            Tambah Ruangan dan Penanggung Jawab
        </button>

        <div class="table-responsive">
            <!-- Tabel -->
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
                                <a href="#" class="icon-button" onclick="confirmDelete('{{ $mahasiswa->id }}')">
                                    <i class="fas fa-trash-alt delete-icon" style="color: red"></i>
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

    <script>
        function confirmDelete(mahasiswaId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data mahasiswa akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Dapatkan CSRF token dari meta tag
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch(`/mahasiswa/delete/${mahasiswaId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => {
                            // Pastikan response dalam bentuk JSON
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: data.message || 'Data mahasiswa berhasil dihapus',
                                    icon: 'success',
                                    timer: 1500
                                }).then(() => {
                                    location.reload(); // Reload halaman
                                });
                            } else {
                                // Jika response success = false
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: data.message || 'Terjadi kesalahan saat menghapus data',
                                    icon: 'error'
                                });
                            }
                        })
                        .catch(error => {
                            // Tangani error jaringan atau parsing
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat mengirim request',
                                icon: 'error'
                            });
                            console.error('Error:', error);
                        });
                }
            });
        }
        //HANDEL DATA TABEL MAHASISWA
        // HANDLE DATA TABEL MATA KULIAH
        $(document).ready(function() {
            $('#mataKuliahTable').DataTable({
                paging: true,
                lengthMenu: [5, 10, 20],
                searching: true,
                info: true,
                language: {
                    lengthMenu: "Show _MENU_ entries",
                    search: "Search:",
                    paginate: {
                        next: "Next",
                        previous: "Previous"
                    },
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                },
                columnDefs: [{
                    orderable: false,
                    targets: [2]
                }, ],
            });
        });
    </script>
@endsection
