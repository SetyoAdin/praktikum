@extends('layout.dash')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <style>
        body.modal-open {
            overflow: hidden;

        }

        .icon-button {
            background: none;
            border: none;
            padding: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .trash-icon {
            color: #dc3545;
            font-size: 1.1rem;
        }

        .icon-button:hover .trash-icon {
            color: #c82333;
        }

        .modal-dialog {
            max-width: 100px;
            /* Ukuran maksimum modal */
            width: 45%;
            /* Lebar responsif */
        }

        .modal-content {
            border-radius: 8px;
            /* Sudut melengkung */
            padding: 10px;
            /* Ruang di dalam modal */
            background-color: #fff;
            /* Warna latar belakang */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Bayangan */
        }
    </style>
    <div class="container-fluid py-5">
        <!-- Form Card -->
        <div class="card shadow-sm border-0 rounded-lg mx-auto" style="width: 100%; max-width: 1000px; max-height: 80vh;">
            <div class="card-body">
                <h2 class="h4 mb-4 text-center text-primary font-weight-bold">Buat Akun Baru</h2>

                <!-- Success and Error Alerts -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Form for Account Creation -->
                <form action="{{ route('register') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                                class="form-control" required>
                            <div class="invalid-feedback">Nama wajib diisi.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="form-control" required>
                            <div class="invalid-feedback">Email wajib diisi.</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                            <div class="invalid-feedback">Password wajib diisi.</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" required>
                            <div class="invalid-feedback">Konfirmasi password wajib diisi.</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <select name="role" id="role" class="form-select" required>
                            <option value="">Pilih Role</option>
                            <option value="super">Super</option>
                            <option value="admin">Admin</option>
                        </select>
                        <div class="invalid-feedback">Role wajib diisi.</div>
                    </div>
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <!-- Input fields -->
                        <button type="submit" class="btn btn-custom w-100 py-2 mt-3">Daftar</button>
                    </form>
                    <div>
                        <button type="button" class="btn btn-custom w-100 py-2 mt-3" data-bs-toggle="modal"
                            data-bs-target="#resetPasswordModal">
                            Ubah Password
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="resetPasswordModalLabel">Reset Password</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="emailDropdown" class="form-label">Pilih Email</label>
                                        <select id="emailDropdown" class="form-select" required>
                                            <option value="">Pilih Email</option>
                                            <!-- Option akan diisi melalui JavaScript -->
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="newPassword" class="form-label">Password Baru</label>
                                        <input type="password" id="newPassword" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Tutup</button>
                                    <button type="button" id="resetPasswordButton" class="btn btn-primary">Ubah
                                        Password</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Card -->
        <div class="card shadow-sm border-0 rounded-lg mx-auto mt-4" style="width: 100%; max-width: 1000px;">
            <div class="card-body">
                <h2 class="h4 mb-4 text-center text-primary font-weight-bold">Daftar Pengguna</h2>
                <table id="userTable" class="table table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($auths as $index => $auth)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $auth->nama }}</td>
                                <td>{{ $auth->email }}</td>
                                <td class="text-center">
                                    <button type="button" class="icon-button edit-btn" data-id="{{ $auth->id }}"
                                        data-nama="{{ $auth->nama }}">
                                        <i class="fas fa-pencil-alt" style="color: green"></i>
                                    </button>
                                    <form action="{{ route('user.delete', $auth->id) }}" method="POST"
                                        class="delete-form" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="icon-button delete-btn">
                                            <i class="fas fa-trash-alt trash-icon"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form id="editForm" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Edit Nama Pengguna</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="editNama" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" id="editNama"
                                                        name="nama" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Update Nama</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
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
                // Inisialisasi DataTable
                var table = $('#userTable').DataTable();

                // Pencarian menggunakan input custom
                $('#searchInput').on('keyup', function() {
                    table.search(this.value).draw();
                });
            });
            document.addEventListener("DOMContentLoaded", function() {
                // Mengambil email dari server
                fetch('/get-emails')
                    .then(response => response.json())
                    .then(data => {
                        const emailDropdown = document.getElementById('emailDropdown');
                        data.forEach(user => {
                            const option = document.createElement('option');
                            option.value = user.email;
                            option.textContent = user.email;
                            emailDropdown.appendChild(option);
                        });
                    });

                // Menangani tombol reset password
                document.getElementById('resetPasswordButton').addEventListener('click', function() {
                    const email = document.getElementById('emailDropdown').value;
                    const newPassword = document.getElementById('newPassword').value;

                    if (!email || !newPassword) {
                        alert('Silakan pilih email dan masukkan password baru.');
                        return;
                    }

                    // Kirim permintaan untuk mereset password
                    fetch(`/reset-password/${email}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Menyertakan CSRF token
                            },
                            body: JSON.stringify({
                                new_password: newPassword
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.message);
                            if (data.success) {
                                // Tutup modal dan reset form jika berhasil
                                $('#resetPasswordModal').modal('hide');
                                document.getElementById('emailDropdown').value = '';
                                document.getElementById('newPassword').value = '';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
            //BUAT AKUN 
            document.addEventListener("DOMContentLoaded", function() {
                // Mengambil pesan dari elemen dengan ID
                const successMessage = document.getElementById('successMessage')?.value;
                const errorMessage = document.getElementById('errorMessage')?.value;

                // Fungsi untuk menampilkan SweetAlert
                function showAlert(title, icon) {
                    Swal.fire({
                        title: title,
                        position: 'top-end',
                        toast: true,
                        icon: icon,
                        showConfirmButton: false,
                        timer: 5000, // Durasi alert (5 detik)
                        timerProgressBar: true, // Menampilkan indikator garis
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer); // Pause timer saat hover
                            toast.addEventListener('mouseleave', Swal
                                .resumeTimer); // Lanjutkan timer saat mouse leave
                        }
                    });
                }

                // Tampilkan SweetAlert untuk pesan sukses jika ada
                if (successMessage) {
                    showAlert(successMessage, 'success');
                }

                // Tampilkan SweetAlert untuk pesan error jika ada
                if (errorMessage) {
                    showAlert(errorMessage, 'error');
                }
            });


            // HAPUS DATA AUTH
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');
                    const url = form.getAttribute('action');

                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        text: 'Apakah Anda yakin ingin menghapus pengguna ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Kirim permintaan hapus via fetch
                            fetch(url, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute('content')
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Simpan status ke localStorage untuk notifikasi setelah reload
                                        localStorage.setItem('deleteSuccess', data.message);
                                        // Refresh halaman
                                        location.reload();
                                    } else {
                                        Swal.fire('Error', data.message, 'error');
                                    }
                                })
                                .catch(error => {
                                    Swal.fire('Error', 'Terjadi kesalahan saat menghapus pengguna.',
                                        'error');
                                });
                        }
                    });
                });
            });

            // Tampilkan notifikasi setelah halaman reload
            window.addEventListener('load', () => {
                const message = localStorage.getItem('deleteSuccess');
                if (message) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: message,
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                    // Hapus pesan dari localStorage setelah ditampilkan
                    localStorage.removeItem('deleteSuccess');
                }
            });
            // Script untuk menangani klik tombol edit
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');
                    const userName = this.getAttribute('data-nama');

                    // Isi modal dengan nama pengguna yang dipilih
                    document.getElementById('editNama').value = userName;

                    // Set action form untuk update nama
                    document.getElementById('editForm').action = `/user/update/${userId}`;

                    // Tampilkan modal
                    var editModal = new bootstrap.Modal(document.getElementById('editModal'), {});
                    editModal.show();
                });
            });
        </script>
    @endsection
