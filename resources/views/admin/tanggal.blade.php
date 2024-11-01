<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Praktikulum</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom styles -->
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Open Sans', sans-serif;
        }

        .content-wrapper {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 30px;
        }

        h2 {
            font-family: 'Lora', serif;
            color: #2c3e50;
            margin-bottom: 30px;
            font-weight: 700;
            font-size: 2rem;
        }

        .table thead th {
            background-color: #2c3e50;
            color: #ffffff;
            border: none;
            font-family: 'Lora', serif;
            font-weight: 400;
            font-size: 1.1rem;
        }
        .table tbody td {
            font-family: 'Open Sans', sans-serif;
            font-weight: 300;
            color: #2c3e50;
        }

        /* Styling untuk tombol Submit */
        .btn-submit {
            background-color: #2c3e50;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
        }

        .btn-submit:hover {
            background-color: #636e72;
            border-color: #636e72;
        }

        /* Styling untuk tombol Hapus */
        .btn-hapus {
            background-color: #b2bec3; /* Abu-abu lembut untuk tombol yang tidak mencolok */
            border-color: #b2bec3;
            color: #2c3e50; /* Warna teks tetap biru tua */
            font-family: 'Open Sans', sans-serif;
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .btn-hapus:hover {
            background-color: #636e72; /* Lebih gelap saat hover */
            border-color: #636e72;
        }

        .modal-header {
            background-color: #2c3e50;
            color: white;
        }

        .form-control {
            border-radius: 20px;
        }

        .btn-primary, .btn-success {
            border-radius: 25px;
        }

        .btn-danger {
            border-radius: 25px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content-wrapper">
            <div class="row">
                <div class="container-fluid">
                    <div class="col-12">
                        <div class="card-body">
                            {{-- <form id="tanggalForm" action="/tambahtanggal" method="POST">
                                @csrf
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group row mb-3">
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal">+Sesi</button>
                                    </div>
                                </div>
                            </form> --}}

                            <!-- Modal untuk tambah sesi -->
                            <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel">Formulir Pengisian</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="/insertjw" method="POST">
                                                @csrf
                                                <div class="form-group row mb-3">
                                                    <label for="id_tanggal" class="col-md-4 col-form-label text-md-right">Tanggal</label>
                                                    <div class="col-md-6">
                                                        <select class="form-control" id="id_tanggal" name="id_tanggal" required>
                                                            <option value="">Pilih Tanggal</option>
                                                            @if($tanggals->isEmpty())
                                                                <option value="">Data tanggal tidak tersedia</option>
                                                            @else
                                                                @foreach($tanggals as $tanggal)
                                                                    <option value="{{ $tanggal->id }}">
                                                                        {{ \Carbon\Carbon::parse($tanggal->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <label for="sesi" class="col-md-4 col-form-label text-md-right">Sesi</label>
                                                    <div class="col-md-6">
                                                        <select class="form-control" id="sesi" name="sesi" required>
                                                            <option value="">Pilih Sesi</option>
                                                            <option value="1">Sesi 1</option>
                                                            <option value="2">Sesi 2</option>
                                                            <option value="3">Sesi 3</option>
                                                            <option value="3">Sesi 4</option>
                                                            <option value="3">Sesi 5</option>
                                                            <option value="3">Sesi 6</option>
                                                            <option value="3">Sesi 7</option>
                                                            <option value="3">Sesi 8</option>
                                                            <option value="3">Sesi 9</option>
                                                            <option value="3">Sesi 10</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <label for="waktu_mulai" class="col-md-4 col-form-label text-md-right">Waktu Mulai</label>
                                                    <div class="col-md-6">
                                                        <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <label for="waktu_selesai" class="col-md-4 col-form-label text-md-right">Waktu Selesai</label>
                                                    <div class="col-md-6">
                                                        <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <label for="kuota" class="col-md-4 col-form-label text-md-right">Kuota</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" id="kuota" name="kuota" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-submit">Buat</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabel Tanggal -->
                            <div class="col-12 mt-4">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tanggals as $key => $tanggal)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($tanggal->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
                                            <td>
                                                {{-- <form action="{{ route('hapus.tanggal', $tanggal->id_tanggal) }}" method="POST"> --}}
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-hapus">Hapus</button> <!-- Tombol Hapus -->
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <a href="/datajadwal" class="btn btn-warning mt-4">Next ></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and jQuery Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
    