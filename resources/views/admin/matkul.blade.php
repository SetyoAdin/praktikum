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
                                <!-- Modal Structure -->
                                <div id="dynamicModal" style="display: none;">
                                    <div class="modal-content">
                                        <span class="close-button" onclick="hideMataKuliahModal()">×</span>
                                        <h4 class="mb-3">Daftar Mata Kuliah</h4>
                                        <div id="mataKuliahContainer">
                                            <!-- Dynamic Mata Kuliah Fields Will Be Injected Here -->
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
                                <th></th>
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
                                                        <div class="sesi-container mb-4">
                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <h4 class="mb-3">{{ $jadwal->sesi }}</h4>
                                                                <div class="checkbox-container" style="display: none;">
                                                                    <input type="checkbox"
                                                                        class="form-check-input delete-checkbox"
                                                                        name="delete_sesi[]"
                                                                        value="{{ $jadwal->id_jadwal }}"
                                                                        data-modal-id="{{ $tanggal->id_tanggal }}">
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
                                                </form>

                                                @if ($sesiJadwals->isEmpty())
                                                    <div class="alert alert-info">
                                                        Belum ada sesi yang tersedia untuk tanggal ini.
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    onclick="toggleDeleteMode({{ $tanggal->id_tanggal }})">Hapus</button>
                                                <button type="button" class="btn btn-warning batal-btn"
                                                    style="display: none;"
                                                    onclick="cancelDelete({{ $tanggal->id_tanggal }})">Batal</button>
                                                <button type="button" class="btn btn-danger delete-session-btn"
                                                    style="display: none;" disabled
                                                    onclick="handleDeleteSession({{ $tanggal->id_tanggal }})">Hapus</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Kembali</button>
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
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#id_mata_kuliah').select2({
                placeholder: "Pilih Mata Kuliah",
                allowClear: true
            });

            // Initialize DataTables
            var tanggalTable = $('#tanggalTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                },
                "columnDefs": [{
                    "orderable": false,
                    "targets": 2
                }]
            });

            var mataKuliahTable = $('#mataKuliahTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                },
                "columnDefs": [{
                    "orderable": false,
                    "targets": 2
                }]
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Ambil elemen modal
            var editModal = new bootstrap.Modal(document.getElementById('editModal'));

            // Event listener untuk setiap ikon pensil
            document.querySelectorAll('.edit-icon').forEach(function(icon) {
                icon.addEventListener('click', function() {
                    var id = this.getAttribute('data-id');
                    var tanggal = this.getAttribute('data-tanggal');

                    // Set nilai input tanggal
                    document.getElementById('tanggal').value = tanggal;
                    document.getElementById('id').value = id;

                    // Mengatur action form
                    var form = document.getElementById('editDateForm');
                    form.action = form.action.replace('placeholder', id);
                });
            });
        });
        $(document).ready(function() {
            $('.modal').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('.modal').on('show.bs.modal', function() {
                $(this).css({
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center'
                });
            });
            $('.modal').on('shown.bs.modal', function() {
                $('body').css('padding-right', '0');
            });
        });
        $('.modal').on('show.bs.modal', function() {
            $(this).css({
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center'
            });
        });

        function closeModal(modalId) {
            $(`#${modalId}`).modal('hide');
        }

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
                            icon: 'info',
                            title: 'Informasi',
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
                        title: 'Informasi',
                        text: error.message,
                        icon: 'info',
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
    </script>

@endsection
