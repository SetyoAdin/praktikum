<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Form Mahasiswa</title>
</head>

<body>
    <div class="container mt-5">
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

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h2>Data Praktikum</h2>
        <form method="POST" action="{{ route('insertmhs') }}" id="mahasiswaForm">
            @csrf
            <div class="mb-3">
                <label for="mata_kuliah" class="form-label">Mata Kuliah</label>
                <select class="form-select" id="mata_kuliah" name="mata_kuliah">
                    <option value="">Pilih Mata Kuliah</option>
                    @foreach ($mata_kuliahs as $mata_kuliah)
                        <option value="{{ $mata_kuliah->id_mata_kuliah }}">{{ $mata_kuliah->matkul }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal</label>
                <select class="form-select" id="tanggal" name="tanggal" disabled>
                    <option value="">Pilih Tanggal</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="sesi" class="form-label">Sesi</label>
                <select class="form-select" id="sesi" name="sesi" disabled>
                    <option value="">Pilih Sesi</option>
                </select>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="waktuMulai" class="form-label">Waktu Mulai</label>
                    <input type="text" class="form-control" id="waktuMulai" name="waktu_mulai" readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="waktuSelesai" class="form-label">Waktu Selesai</label>
                    <input type="text" class="form-control" id="waktuSelesai" name="waktu_selesai" readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="kuota" class="form-label">Kuota</label>
                    <input type="text" class="form-control" id="kuota" name="kuota" readonly>
                </div>
            </div>


            <h2>Data Pribadi</h2>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" class="form-control" id="nim" name="nim" required>
            </div>
            <div class="mb-3">
                <label for="kelas" class="form-label">Kelas</label>
                <select class="form-select" id="kelas" name="kelas" required>
                    <option value="" selected>Pilih Kelas</option>
                    @foreach ($kelas as $kelas)
                        <option value="{{ $kelas->kelas }}">{{ $kelas->kelas }}</option>
                    @endforeach
                </select>
            </div>
            <a href="/halaman" type="submit" class="btn btn-warning">Kembali</a>
            <button type="button" class="btn btn-primary" onclick="confirmSubmit()">Kirim</button>
        </form>

    </div>

    <!-- Bootstrap JS (optional, for certain features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const matkulSelect = document.getElementById('mata_kuliah');
            const tanggalSelect = document.getElementById('tanggal');
            const sesiSelect = document.getElementById('sesi');

            // Event listener untuk mata kuliah
            matkulSelect.addEventListener('change', function() {
                const matkulId = this.value;
                tanggalSelect.innerHTML = '<option value="">Memuat tanggal...</option>';
                tanggalSelect.disabled = true;
                sesiSelect.innerHTML = '<option value="">Pilih Sesi</option>';
                sesiSelect.disabled = true;

                // Reset form fields
                document.getElementById('waktuMulai').value = '';
                document.getElementById('waktuSelesai').value = '';
                document.getElementById('kuota').value = '';

                if (matkulId) {
                    fetch(`/get-tanggal/${matkulId}`)
                        .then(response => response.json())
                        .then(data => {
                            tanggalSelect.innerHTML = '<option value="">Pilih Tanggal</option>';
                            if (data.length > 0) {
                                data.forEach(item => {
                                    const option = document.createElement('option');
                                    option.value = item.id_tanggal; // Menggunakan id_tanggal
                                    option.textContent = formatTanggal(item.tanggal);
                                    tanggalSelect.appendChild(option);
                                });
                                tanggalSelect.disabled = false;
                                sesiSelect.disabled = true;
                            } else {
                                tanggalSelect.innerHTML = '<option value="">Tidak ada tanggal</option>';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            tanggalSelect.innerHTML = '<option value="">Error loading dates</option>';
                        });
                }
            });

            // Event listener untuk tanggal
            tanggalSelect.addEventListener('change', function() {
                const tanggalId = this.value;

                // Reset sesi select
                sesiSelect.innerHTML = '<option value="">Pilih Sesi</option>';
                sesiSelect.disabled = true;

                // Reset form fields
                document.getElementById('waktuMulai').value = '';
                document.getElementById('waktuSelesai').value = '';
                document.getElementById('kuota').value = '';

                if (tanggalId) {
                    // Fetch sesi berdasarkan tanggal
                    fetch(`/get-sesi/${tanggalId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                data.forEach(jadwal => {
                                    const option = document.createElement('option');
                                    option.value = jadwal.id_jadwal;
                                    option.textContent = jadwal.sesi;
                                    sesiSelect.appendChild(option);
                                });
                                sesiSelect.disabled = false;
                            } else {
                                sesiSelect.innerHTML =
                                    '<option value="">Tidak ada sesi tersedia</option>';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            sesiSelect.innerHTML = '<option value="">Error loading sessions</option>';
                        });
                }
            });

            // Event listener untuk sesi
            sesiSelect.addEventListener('change', function() {
                const jadwalId = this.value;

                // Reset form fields
                document.getElementById('waktuMulai').value = '';
                document.getElementById('waktuSelesai').value = '';
                document.getElementById('kuota').value = '';

                if (jadwalId) {
                    fetch(`/get-jadwal-detail/${jadwalId}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('waktuMulai').value = data.waktu_mulai;
                            document.getElementById('waktuSelesai').value = data.waktu_selesai;
                            document.getElementById('kuota').value = data.kuota;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            });

            function formatTanggal(tanggal) {
                return new Date(tanggal).toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            }

            // Form submission handler
            const form = document.querySelector('form');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const submitButton = form.querySelector('button[type="submit"]');

                // Disable button to prevent double submission
                submitButton.disabled = true;

                fetch('{{ route('insertmhs') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            // Reset form dan disable selects
                            form.reset();
                            tanggalSelect.disabled = true;
                            sesiSelect.disabled = true;
                            document.getElementById('waktuMulai').value = '';
                            document.getElementById('waktuSelesai').value = '';
                            document.getElementById('kuota').value = '';
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengirim data');
                    })
                    .finally(() => {
                        // Re-enable button
                        submitButton.disabled = false;
                    });
            });
        });
        //Alert success
        document.addEventListener('DOMContentLoaded', function() {
            const matkulSelect = document.getElementById('mata_kuliah');
            const tanggalSelect = document.getElementById('tanggal');
            const sesiSelect = document.getElementById('sesi');

            // Event listener untuk mata kuliah
            matkulSelect.addEventListener('change', function() {
                const matkulId = this.value;
                resetTanggalSelect();
                resetSesiSelect();
                resetFormFields();

                if (matkulId) {
                    fetch(`/get-tanggal/${matkulId}`)
                        .then(response => response.json())
                        .then(data => {
                            tanggalSelect.innerHTML = '<option value="">Pilih Tanggal</option>';
                            if (data.length > 0) {
                                data.forEach(item => {
                                    const option = document.createElement('option');
                                    option.value = item.id_tanggal;
                                    option.textContent = formatTanggal(item.tanggal);
                                    tanggalSelect.appendChild(option);
                                });
                                tanggalSelect.disabled = false;
                            } else {
                                tanggalSelect.innerHTML = '<option value="">Tidak ada tanggal</option>';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            tanggalSelect.innerHTML = '<option value="">Error loading dates</option>';
                        });
                }
            });

            // Event listener untuk tanggal
            tanggalSelect.addEventListener('change', function() {
                const tanggalId = this.value;
                resetSesiSelect();
                resetFormFields();

                if (tanggalId) {
                    fetch(`/get-sesi/${tanggalId}`)
                        .then(response => response.json())
                        .then(data => {
                            // Reset dan set default option
                            sesiSelect.innerHTML = '<option value="">Pilih Sesi</option>';

                            if (data.length > 0) {
                                data.forEach(jadwal => {
                                    const option = document.createElement('option');
                                    option.value = jadwal.id_jadwal;
                                    option.textContent = jadwal.sesi;
                                    sesiSelect.appendChild(option);
                                });
                                sesiSelect.disabled = false;
                            } else {
                                sesiSelect.innerHTML =
                                    '<option value="">Tidak ada sesi tersedia</option>';
                                sesiSelect.disabled = true;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            sesiSelect.innerHTML = '<option value="">Error loading sessions</option>';
                            sesiSelect.disabled = true;
                        });
                }
            });

            // Event listener untuk sesi
            sesiSelect.addEventListener('change', function() {
                const jadwalId = this.value;
                resetFormFields();

                if (jadwalId) {
                    fetch(`/get-jadwal-detail/${jadwalId}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('waktuMulai').value = data.waktu_mulai;
                            document.getElementById('waktuSelesai').value = data.waktu_selesai;
                            document.getElementById('kuota').value = data.kuota;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            resetFormFields();
                        });
                }
            });

            // Helper functions untuk reset select dan fields
            function resetTanggalSelect() {
                tanggalSelect.innerHTML = '<option value="">Pilih Tanggal</option>';
                tanggalSelect.disabled = true;
            }

            function resetSesiSelect() {
                sesiSelect.innerHTML = '<option value="">Pilih Sesi</option>';
                sesiSelect.disabled = true;
            }

            function resetFormFields() {
                document.getElementById('waktuMulai').value = '';
                document.getElementById('waktuSelesai').value = '';
                document.getElementById('kuota').value = '';
            }

            function formatTanggal(tanggal) {
                return new Date(tanggal).toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            }

            // Function to handle form submission with SweetAlert
            window.confirmSubmit = function() {
                // Get form data
                const form = document.getElementById('mahasiswaForm');
                const formData = new FormData(form);

                // Validate required fields
                const requiredFields = ['mata_kuliah', 'tanggal', 'sesi', 'nama', 'nim', 'kelas'];
                const emptyFields = requiredFields.filter(field => !formData.get(field));

                if (emptyFields.length > 0) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Mohon lengkapi semua field yang diperlukan',
                        icon: 'error'
                    });
                    return;
                }

                // Show confirmation dialog
                Swal.fire({
                    title: 'Konfirmasi Data',
                    html: `
                <div class="text-left">
                    <p><strong>Nama:</strong> ${formData.get('nama')}</p>
                    <p><strong>NIM:</strong> ${formData.get('nim')}</p>
                    <p><strong>Kelas:</strong> ${formData.get('kelas')}</p>
                    <p><strong>Mata Kuliah:</strong> ${document.querySelector('#mata_kuliah option:checked').text}</p>
                    <p><strong>Sesi:</strong> ${document.querySelector('#sesi option:checked').text}</p>
                    <p><strong>Waktu:</strong> ${formData.get('waktu_mulai')} - ${formData.get('waktu_selesai')}</p>
                </div>
                <p class="text-warning mt-3">Harap cek kembali data Anda sebelum mengirim!</p>
            `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Kirim!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        Swal.fire({
                            title: 'Sedang Memproses...',
                            html: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Submit form data
                        fetch(form.getAttribute('action'), {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')
                                        .value,
                                    'Accept': 'application/json'
                                },
                                body: formData
                            })
                            .then(response => response.json())
                            .then(result => {
                                if (result.success) {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: result.message,
                                        icon: 'success',
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(() => {
                                        window.location.href = '/halaman';
                                    });
                                } else {
                                    throw new Error(result.message);
                                }
                            })
                            .catch(error => {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: error.message ||
                                        'Terjadi kesalahan saat mengirim data',
                                    icon: 'error'
                                });
                            });
                    }
                });
            };
        });
    </script>

</body>

</html>
