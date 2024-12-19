@extends('layout.dash')
@section('content')
    <style>
        #dynamicModal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .modal-content h4 {
            text-align: center;
        }

        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .row {
            display: flex;
            align-items: center;
        }

        .col-md-4,
        .col-md-5 {
            padding: 5px;
        }

        //tabel kelas
        #pagination {
            display: flex;
            justify-content: flex-end;
            gap: 5px;
        }

        .page-btn {
            padding: 5px 10px;
            border: 1px solid #ccc;
            background-color: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .page-btn.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .page-btn:disabled {
            cursor: not-allowed;
            background-color: #f8f9fa;
            border-color: #ccc;
        }

        /*HANDEL TAMPILAN DATA TABEL KELAS*/
        /* Search Bar Styling */
        .dataTables_wrapper .dataTables_filter {
            text-align: right;
            margin-bottom: 10px;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #ddd;
            /* Border ringan */
            border-radius: 4px;
            /* Membulatkan sudut */
            padding: 5px 10px;
            /* Padding dalam */
            outline: none;
            transition: all 0.3s ease;
            /* Efek transisi */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Efek bayangan */
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #2c3e50;
            /* Warna fokus */
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
            /* Bayangan fokus */
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
    <div class="container">
        <h1 class="page-title">Manajemen Jadwal</h1>

        <div class="form-container">
            <div class="form-section">
                <h3 class="form-section-title">Tambah Mata Kuliah</h3>
                <form id="mataKuliahForm" action="{{ route('insertmatkul') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="mataKuliah" class="form-label">Nama Mata Kuliah</label>
                        <input type="text" class="form-control" id="mataKuliah" name="mataKuliah" required>
                    </div>
                    <button type="submit" class="btn btn-custom">Buat Mata Kuliah</button>
                </form>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">Tambah Tanggal</h3>
                <form id="tambahTanggalForm" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="id_mata_kuliah" class="form-label">Pilih Mata Kuliah</label>
                        <select class="form-select" id="id_mata_kuliah" name="id_mata_kuliah" required>
                            <option value="" disabled selected>Pilih Mata Kuliah</option>
                            @foreach ($mata_kuliahs as $mata_kuliah)
                                <option value="{{ $mata_kuliah->id_mata_kuliah }}">{{ $mata_kuliah->matkul }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-custom">Buat Tanggal</button>

                        <form id="tanggalForm" action="/tambahtanggal" method="POST" class="m-0">
                            @csrf
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="button" class="btn btn-custom" data-bs-toggle="modal"
                                data-bs-target="#myModal">+Sesi</button>

                        </form>
                        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">Formulir Pengisian</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="jadwalForm" action="{{ route('insertjw') }}" method="POST">
                                            @csrf
                                            <div class="form-group row mb-3">
                                                <label for="id_tanggal"
                                                    class="col-md-4 col-form-label text-md-right">Tanggal</label>
                                                <div class="col-md-6">
                                                    <select class="form-control" id="id_tanggal" name="id_tanggal" required>
                                                        <option value="">Pilih Tanggal</option>
                                                        @if ($tanggals->isEmpty())
                                                            <option value="">Data tanggal tidak tersedia</option>
                                                        @else
                                                            @foreach ($tanggals as $tanggal)
                                                                <option value="{{ $tanggal->id_tanggal }}">
                                                                    {{ \Carbon\Carbon::parse($tanggal->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                                                    - {{ $tanggal->mataKuliah->matkul }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3">
                                                <label for="sesi"
                                                    class="col-md-4 col-form-label text-md-right">Sesi</label>
                                                <div class="col-md-6">
                                                    <select class="form-control" id="sesi" name="sesi" required>
                                                        <option value="">Pilih Sesi</option>
                                                        @for ($i = 1; $i <= 10; $i++)
                                                            <option value="Sesi {{ $i }}">
                                                                {{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3">
                                                <label for="waktu_mulai" class="col-md-4 col-form-label text-md-right">Waktu
                                                    Mulai</label>
                                                <div class="col-md-6">
                                                    <input type="time" class="form-control" id="waktu_mulai"
                                                        name="waktu_mulai" required>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3">
                                                <label for="waktu_selesai"
                                                    class="col-md-4 col-form-label text-md-right">Waktu
                                                    Selesai</label>
                                                <div class="col-md-6">
                                                    <input type="time" class="form-control" id="waktu_selesai"
                                                        name="waktu_selesai" required>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3">
                                                <label for="kuota"
                                                    class="col-md-4 col-form-label text-md-right">Kuota</label>
                                                <div class="col-md-6">
                                                    <input type="number" class="form-control" id="kuota"
                                                        name="kuota" required min="1">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Kembali</button>
                                                <button type="submit" class="btn btn-custom">Buat</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="form-section">
                <h3 class="form-section-title">Tambah Kelas</h3>
                <form id="kelasForm" action="{{ route('insertkelas') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="kelas" class="form-label">Nama Kelas</label>
                        <input type="text" class="form-control" id="kelas" name="kelas" required>
                    </div>

                    <button type="submit" class="btn btn-custom">Buat Kelas</button>
                </form>
            </div>
        </div>

        <div class="container mt-4">
            <!-- Tabel Mata Kuliah -->
            <div class="table-card">
                <h3 class="card-title">Daftar Mata Kuliah</h3>
                <div class="table-responsive">
                    <table id="mataKuliahTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Mata Kuliah</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mata_kuliahs as $matkul)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $matkul->matkul }}</td>
                                    <td>
                                        <form id="delete-matkul-form-{{ $matkul->id_mata_kuliah }}" class="delete-form"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="icon-button delete-btn"
                                                onclick="confirmDeleteMataKuliah({{ $matkul->id_mata_kuliah }})">
                                                <i class="fas fa-trash-alt trash-icon"></i>
                                            </button>
                                        </form>

                                        <a href="#" class="icon-button"
                                            onclick="openEditModal('{{ $matkul->id_mata_kuliah }}', '{{ $matkul->matkul }}')">
                                            <i class="fas fa-pencil-alt edit-icon"></i>
                                        </a>

                                    </td>
                                </tr>
                                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Edit Mata Kuliah</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="edit-form">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="nama-matkul" class="form-label">Nama Mata
                                                            Kuliah</label>
                                                        <input type="text" class="form-control" id="nama-matkul"
                                                            name="matkul" value="">
                                                    </div>
                                                    <input type="hidden" id="matkul-id" name="id_mata_kuliah"
                                                        value="">
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary"
                                                    onclick="updateMatkul()">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Tabel Tanggal -->
            <div class="table-card">
                <h3 class="card-title">Daftar Jadwal</h3>
                <div class="table-responsive">
                    <table id="tanggalTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th style="width: 3cm;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tanggals as $tanggal)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($tanggal->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                    </td>
                                    <td>
                                        <form id="delete-tanggal-form-{{ $tanggal->id_tanggal }}" class="delete-form"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="icon-button delete-btn"
                                                onclick="confirmDeleteTanggal({{ $tanggal->id_tanggal }})">
                                                <i class="fas fa-trash-alt trash-icon"></i>
                                            </button>
                                        </form>

                                        <a href="#" class="icon-button edit-icon" data-bs-toggle="modal"
                                            data-bs-target="#editModaltgl" data-id="{{ $tanggal->id_tanggal }}"
                                            data-tanggal="{{ $tanggal->tanggal }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>

                                        <a href="#" class="icon-button" data-bs-toggle="modal"
                                            data-bs-target="#staticBackdrop{{ $tanggal->id_tanggal }}">
                                            <i class="fas fa-eye" style="color: blue"></i>
                                        </a>
                                    </td>
                                </tr>
                                <!-- Modal untuk Detail Jadwal -->
                                <div class="modal fade" id="staticBackdrop{{ $tanggal->id_tanggal }}"
                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                    aria-labelledby="staticBackdropLabel{{ $tanggal->id_tanggal }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h2 class="modal-title"
                                                    id="staticBackdropLabel{{ $tanggal->id_tanggal }}">
                                                    <b>Detail Jadwal
                                                        {{ \Carbon\Carbon::parse($tanggal->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</b>
                                                </h2>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @php
                                                    $sesiJadwals = $jadwals->where('id_tanggal', $tanggal->id_tanggal);
                                                @endphp

                                                <form id="deleteForm{{ $tanggal->id_tanggal }}">
                                                    @foreach ($sesiJadwals as $jadwal)
                                                        <div class="sesi-container mb-4"
                                                            data-jadwal-id="{{ $jadwal->id_jadwal }}">
                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <h4 class="mb-3">{{ $jadwal->sesi }}</h4>
                                                                <div>
                                                                    <button type="button" class="icon-button delete-btn"
                                                                        onclick="deleteSesi('{{ $jadwal->id_jadwal }}')">
                                                                        <i class="fas fa-trash-alt trash-icon"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-md-4">Waktu Mulai</div>
                                                                <div class="col-md-5">:
                                                                    {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-md-4">Waktu Selesai</div>
                                                                <div class="col-md-5">:
                                                                    {{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-md-4">Kuota</div>
                                                                <div class="col-md-5">: {{ $jadwal->kuota }}</div>
                                                            </div>
                                                        </div>

                                                        @if (!$loop->last)
                                                            <hr class="my-4">
                                                        @endif
                                                    @endforeach

                                                    @if ($sesiJadwals->isEmpty())
                                                        <div class="alert alert-info mt-5 text-center py-4">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-16 w-16 mx-auto mb-3 text-blue-500"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9.172 16.172a4 4 0 015.656 0M9 12h.01M15 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            <h5 class="alert-heading mb-3">Belum Ada Sesi Tersedia</h5>
                                                            <p class="mb-0">
                                                                Tidak ada jadwal yang telah direncanakan untuk tanggal
                                                                <strong>{{ \Carbon\Carbon::parse($tanggal->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</strong>.
                                                                Silakan tambahkan sesi baru.
                                                            </p>
                                                        </div>
                                                    @endif
                                                </form>
                                            </div>


                                            <div class="modal-footer">
                                                <form action="{{ url()->current() }}" method="get">
                                                    @csrf
                                                    <button type="submit" class="btn btn-secondary">Kembali</button>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="editModaltgl" tabindex="-1"
                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Edit Tanggal</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editTanggalForm">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" id="edit-id-tanggal" name="id_tanggal">

                                                    <div class="mb-3">
                                                        <label for="edit-tanggal" class="form-label">Tanggal</label>
                                                        <input type="date" class="form-control" id="edit-tanggal"
                                                            name="tanggal" required>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Daftar Kelas -->
            <div class="table-card">
                <h3 class="card-title">Daftar Kelas</h3>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="table-responsive mt-3">
                        <table id="kelasTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelas as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kelas }}</td>
                                        <td>
                                            <button type="button" class="icon-button delete-btn"
                                                onclick="confirmDeleteKelas({{ $item->id }})">
                                                <i class="fas fa-trash-alt trash-icon"></i>
                                            </button>
                                            <button type="button" class="icon-button"
                                                onclick="openKelasEditModal({{ $item->id }}, '{{ $item->kelas }}')">
                                                <i class="fas fa-pencil-alt edit-icon"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="kelasEditModal" tabindex="-1"
                                        aria-labelledby="kelasEditModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="kelasEditModalLabel">Edit Kelas</h5>
                                                    <button type="button" class="btn-close" onclick="closeEditModal()"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editKelasModalForm">
                                                        @csrf
                                                        <input type="hidden" id="kelasEditModalId" name="id">

                                                        <div class="mb-3">
                                                            <label for="kelasEditModalName" class="form-label">Nama
                                                                Kelas</label>
                                                            <input type="text" class="form-control"
                                                                id="kelasEditModalName" name="kelas" required>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                onclick="closeEditModal()">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan
                                                                Perubahan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            //HANDEL HAPUS SESI PADA TABEL JADWAL
            function deleteSesi(idJadwal) {
                fetch(`/jadwal/delete/${idJadwal}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                    })
                    .then(response => {
                        if (response.ok) {
                            // Refresh atau hapus elemen sesi dari DOM jika berhasil
                            document.querySelector(`[data-jadwal-id="${idJadwal}"]`).remove();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
            // HANDEL MODAL EDIT KELAS
            function openKelasEditModal(id, kelas) {
                $('#kelasEditModalId').val(id);
                $('#kelasEditModalName').val(kelas);
                $('#kelasEditModal').modal('show');
            }

            $(document).ready(function() {
                $('#editKelasModalForm').on('submit', function(e) {
                    e.preventDefault(); // Mencegah form refresh

                    let id = $('#kelasEditModalId').val();
                    let kelas = $('#kelasEditModalName').val();

                    // Validasi input di sisi klien
                    if (!kelas.trim()) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Nama kelas tidak boleh kosong.'
                        });
                        return;
                    }

                    // Kirim AJAX
                    $.ajax({
                        url: `/editkelas/${id}`, // Pastikan route benar
                        type: 'PUT',
                        dataType: 'json',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            kelas: kelas
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.success || 'Kelas berhasil diupdate',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload(); // Refresh halaman
                            });
                        },
                        error: function(xhr) {
                            let response = xhr.responseJSON;

                            if (response) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: response.message ||
                                        'Terjadi kesalahan saat memperbarui data.'
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan tak terduga.'
                                });
                            }
                        }
                    });
                });
            });

            //HANDLE DATA TABEL MATA KULIAH
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
                            previous: "Previous",
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

            // HANDLE DATA TABLE JADWAL
            $(document).ready(function() {
                $('#tanggalTable').DataTable({
                    "paging": true,
                    "lengthMenu": [5, 10, 20],
                    "searching": true,
                    "info": true,
                    "language": {
                        "lengthMenu": "Show _MENU_ entries",
                        "search": "Search:",
                        "paginate": {
                            "next": "Next",
                            "previous": "Previous"
                        },
                        "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                        "infoEmpty": "Showing 0 to 0 of 0 entries",
                        "infoFiltered": "(filtered from _MAX_ total entries)"
                    }
                });
            });



            //HANDEL DATA TABEL KELAS
            $(document).ready(function() {
                $('#kelasTable').DataTable({
                    "paging": true,
                    "lengthMenu": [5, 10, 20],
                    "searching": true,
                    "info": true,
                    "language": {
                        "lengthMenu": "Show _MENU_ entries",
                        "search": "Search:",
                        "paginate": {
                            "first": "First",
                            "last": "Last",
                            "next": "Next",
                            "previous": "Previous"
                        },
                        "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                        "infoEmpty": "Showing 0 to 0 of 0 entries",
                        "infoFiltered": "(filtered from _MAX_ total entries)"
                    }
                });
            });
            //HANDEL ALERT HAPUS KELAS
            function confirmDeleteKelas(id) {
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
                        // Kirimkan permintaan DELETE ke server
                        $.ajax({
                            url: `/kelas/${id}`, // URL sesuai route
                            type: 'DELETE',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content') // Token CSRF
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Terhapus!',
                                    response.success,
                                    'success'
                                ).then(() => {
                                    // Refresh halaman atau hapus baris tabel
                                    location.reload();
                                });
                            },
                            error: function() {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            }
            //DELETE MATA KULIAH
            function deleteMatkul(id) {
                fetch(`/delmatkul/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Hapus elemen dari DOM
                            document.querySelector(`#delete-form-${id}`).closest('tr').remove();
                            alert(data.message);
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menghapus data');
                    });
            }
            document.getElementById('jadwalForm').addEventListener('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Tutup modal jika ada
                        let modal = bootstrap.Modal.getInstance(document.querySelector('.modal'));
                        if (modal) {
                            modal.hide();
                        }

                        // Tampilkan SweetAlert2 sesuai response
                        if (data.status === 'success') {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message,
                                icon: 'success',
                                timerProgressBar: true,
                                timer: 4500,
                                showConfirmButton: false
                            }).then(() => {
                                // Refresh halaman setelah alert tertutup
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.message,
                                icon: 'error',
                                timerProgressBar: true,
                                timer: 4500,
                                showConfirmButton: false
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan pada server',
                            icon: 'error',
                            timerProgressBar: true,
                            timer: 5500,
                            showConfirmButton: false
                        });
                    });
            });


            document.getElementById('mataKuliahForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const submitButton = this.querySelector('button[type="submit"]');

                // Disable button saat proses submit
                submitButton.disabled = true;

                fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reset form
                            this.reset();

                            // Alert sukses
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Mata Kuliah berhasil ditambahkan',
                                icon: 'success',
                                timer: 5000,
                                timerProgressBar: true,
                                showConfirmButton: false,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            }).then(() => {
                                // Refresh halaman setelah alert tertutup
                                window.location.reload();
                            });
                        } else {
                            throw new Error(data.message || 'Terjadi kesalahan saat menambahkan mata kuliah');
                        }
                    })
                    .catch(error => {
                        // Alert error
                        Swal.fire({
                            title: 'Error!',
                            text: error.message || 'Terjadi kesalahan pada server',
                            icon: 'error',
                            timer: 5000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });
                    })
                    .finally(() => {
                        // Enable kembali button setelah proses selesai
                        submitButton.disabled = false;
                    });
            });
            //HANDEL MODAL EDIT MATKUL
            function openEditModal(id, namaMatkul) {
                // Isi input dengan nama mata kuliah yang diambil dari server
                document.getElementById('nama-matkul').value = namaMatkul;
                document.getElementById('matkul-id').value = id;

                // Tampilkan modal
                var editModal = new bootstrap.Modal(document.getElementById('editModal'));
                editModal.show();
            }

            function updateMatkul() {
                // Ambil data dari form
                var formData = new FormData(document.getElementById('edit-form'));

                // Kirim request ke backend untuk update
                fetch(`/mata-kuliah/${formData.get('id_mata_kuliah')}`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Berhasil diperbarui, tampilkan SweetAlert sukses tanpa ikon loading
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Mata kuliah berhasil diperbarui!',
                                timer: 5000, // 5 detik
                                timerProgressBar: true, // Menampilkan garis progress
                                showConfirmButton: false, // Tidak menampilkan tombol konfirmasi
                                willClose: () => {
                                    location.reload(); // Reload halaman setelah alert tertutup
                                }
                            });
                        } else {
                            // Gagal diperbarui, tampilkan SweetAlert gagal tanpa ikon loading
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Mata kuliah gagal diperbarui. Coba lagi.',
                                timer: 5000, // 5 detik
                                timerProgressBar: true, // Menampilkan garis progress
                                showConfirmButton: false, // Tidak menampilkan tombol konfirmasi
                            });
                        }
                    })
                    .catch(error => {
                        // Jika terjadi error (seperti kesalahan jaringan)
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan. Silakan coba lagi nanti.',
                            timer: 5000, // 5 detik
                            timerProgressBar: true, // Menampilkan garis progress
                            showConfirmButton: false, // Tidak menampilkan tombol konfirmasi
                        });
                        console.error('Error:', error);
                    });
            }
            //HENDEL ALERT TAMBAH TANGGAL
            document.getElementById('tambahTanggalForm').addEventListener('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                fetch('{{ route('inserttanggal') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: data.message,
                                timer: 5000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Tanggal sudah ada untuk mata kuliah ini',
                                timer: 5000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.message || 'Terjadi kesalahan saat menambah tanggal.',
                            timer: 5000,
                            timerProgressBar: true,
                            showConfirmButton: false
                        });
                    });
            });
            document.addEventListener('DOMContentLoaded', function() {
                const editModal = document.getElementById('editModaltgl');
                editModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget; // Button yang memicu modal
                    const id = button.getAttribute('data-id'); // Ambil data-id
                    const tanggal = button.getAttribute('data-tanggal'); // Ambil data-tanggal

                    // Isi input dengan data yang diambil
                    editModal.querySelector('#edit-id-tanggal').value = id;
                    editModal.querySelector('#edit-tanggal').value = tanggal;
                });
            });
            //MODAL EDIT TANGGAL
            document.getElementById('editTanggalForm').addEventListener('submit', function(e) {
                e.preventDefault(); // Mencegah reload halaman

                const id = document.getElementById('edit-id-tanggal').value; // Ambil ID
                const tanggal = document.getElementById('edit-tanggal').value; // Ambil tanggal

                fetch(`/updatetanggal/${id}`, { // Pastikan URL ini sesuai
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            tanggal: tanggal
                        }) // Data yang dikirim
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message,
                                icon: 'success',
                                timer: 5000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload(); // Refresh halaman setelah berhasil
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.message || 'Terjadi kesalahan saat mengupdate tanggal',
                                icon: 'error',
                                timer: 5000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat mengupdate tanggal',
                            icon: 'error',
                            timer: 5000,
                            timerProgressBar: true,
                            showConfirmButton: false
                        });
                    });
            });

            document.getElementById('kelasForm').addEventListener('submit', function(e) {
                e.preventDefault(); // Mencegah reload halaman

                const formData = new FormData(this); // Ambil data dari form

                fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        }
                    })
                    .then(response => {
                        // Cek status response
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw new Error(data.message || 'Terjadi kesalahan pada server');
                            });
                        }
                        return response.json(); // Kembalikan response dalam format JSON
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message,
                                icon: 'success',
                                timer: 5000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload(); // Refresh halaman setelah berhasil
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error',
                            text: error.message,
                            icon: 'error',
                            timer: 5000,
                            timerProgressBar: true,
                            showConfirmButton: false
                        });
                    });
            });
            //HAPUS DATA JADWAL DI DALAM MODAL

            function hideMataKuliahModal() {
                document.getElementById('dynamicModal').style.display = 'none';
            }
            /*HAPUS PADA TABEL MATA KULIAH DAN TANGGAL*/
            // public/js/delete-handlers.js
            function confirmDeleteMataKuliah(id) {
                Swal.fire({
                    title: 'Hapus Mata Kuliah?',
                    text: "Semua data tanggal dan jadwal terkait akan ikut terhapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteMataKuliah(id);
                    }
                });
            }

            function confirmDeleteTanggal(id) {
                Swal.fire({
                    title: 'Hapus Tanggal?',
                    text: "Semua data jadwal terkait akan ikut terhapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteTanggal(id);
                    }
                });
            }

            function deleteMataKuliah(id) {
                $.ajax({
                    url: `/mata-kuliah/${id}`,
                    type: 'DELETE',
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Terhapus!',
                                response.message,
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Gagal!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat menghapus data',
                            'error'
                        );
                    }
                });
            }

            function deleteTanggal(id) {
                $.ajax({
                    url: `/tanggal/${id}`,
                    type: 'DELETE',
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Terhapus!',
                                response.message,
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Gagal!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat menghapus data',
                            'error'
                        );
                    }
                });
            }
            //HANDEL TABEL KELAS
            document.addEventListener('DOMContentLoaded', function() {
                let rowsPerPage = 5; // Default rows per page
                const table = document.getElementById('kelasTable');
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.getElementsByTagName('tr'));
                const pagination = document.getElementById('pagination');
                const searchInput = document.getElementById('searchInput');
                const entriesSelect = document.getElementById('entriesSelect');

                let currentPage = 1;
                let filteredRows = [...rows]; // Filtered rows (search)

                // Function to render the table
                function renderTable() {
                    tbody.innerHTML = '';
                    const start = (currentPage - 1) * rowsPerPage;
                    const end = start + rowsPerPage;
                    const paginatedRows = filteredRows.slice(start, end);

                    paginatedRows.forEach((row, index) => {
                        const clonedRow = row.cloneNode(true);
                        clonedRow.firstElementChild.textContent = start + index + 1; // Update row number
                        tbody.appendChild(clonedRow);
                    });
                    renderPagination();
                }

                // Function to render pagination buttons
                function renderPagination() {
                    pagination.innerHTML = '';
                    const totalPages = Math.ceil(filteredRows.length / rowsPerPage);

                    // Previous Button
                    const prevButton = document.createElement('button');
                    prevButton.textContent = 'Previous';
                    prevButton.classList.add('page-btn');
                    prevButton.disabled = currentPage === 1;
                    prevButton.addEventListener('click', () => {
                        currentPage--;
                        renderTable();
                    });
                    pagination.appendChild(prevButton);

                    // Page Numbers
                    for (let i = 1; i <= totalPages; i++) {
                        const button = document.createElement('button');
                        button.textContent = i;
                        button.classList.add('page-btn');
                        if (i === currentPage) {
                            button.classList.add('active');
                        }
                        button.addEventListener('click', () => {
                            currentPage = i;
                            renderTable();
                        });
                        pagination.appendChild(button);
                    }

                    // Next Button
                    const nextButton = document.createElement('button');
                    nextButton.textContent = 'Next';
                    nextButton.classList.add('page-btn');
                    nextButton.disabled = currentPage === totalPages;
                    nextButton.addEventListener('click', () => {
                        currentPage++;
                        renderTable();
                    });
                    pagination.appendChild(nextButton);
                }

                // Function to filter rows based on search input
                function filterKelas() {
                    const searchValue = searchInput.value.toLowerCase();
                    filteredRows = rows.filter(row => {
                        const kelasText = row.children[1].textContent.toLowerCase();
                        return kelasText.includes(searchValue);
                    });
                    currentPage = 1; // Reset to first page
                    renderTable();
                }

                // Function to handle change in entries per page
                function changeEntries() {
                    rowsPerPage = parseInt(entriesSelect.value, 10);
                    currentPage = 1; // Reset to first page
                    renderTable();
                }

                // Attach event listeners
                searchInput.addEventListener('input', filterKelas);
                entriesSelect.addEventListener('change', changeEntries);

                // Initial rendering
                renderTable();

                // Functions for modal actions (example)
                window.openEditModal = function(id, kelas) {
                    alert(`Edit Kelas: ID=${id}, Nama=${kelas}`);
                    // Your modal logic here
                };

                window.confirmDeleteKelas = function(id) {
                    if (confirm('Apakah Anda yakin ingin menghapus kelas ini?')) {
                        alert(`Kelas dengan ID ${id} telah dihapus`);
                        // Your delete logic here
                    }
                };
            });
        </script>

    @endsection
