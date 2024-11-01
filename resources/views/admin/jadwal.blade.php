<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Praktikulum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
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
            font-weight: 900;
            font-size: 2.5rem;
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
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(44, 62, 80, 0.05);
        }
        .btn-custom {
            background-color: #b2bec3;
            border-color: #b2bec3;
            color: #2c3e50;
            font-family: 'Open Sans', sans-serif;
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .btn-custom:hover {
            background-color: #636e72;
            border-color: #636e72;
        }
        .modal-content {
            border-radius: 15px;
        }
        .modal-header {
            background-color: #2c3e50;
            color: #ffffff;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .modal-title {
            font-family: 'Lora', serif;
            font-weight: 700;
        }
        .modal-body h4 {
            font-family: 'Lora', serif;
            color: #2c3e50;
            font-weight: 400;
        }
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #2c3e50;
            border-radius: 20px;
            padding: 5px 15px;
        }
        .dataTables_wrapper .dataTables_filter label {
            font-family: 'Open Sans', sans-serif;
            font-weight: 400;
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content-wrapper">
            <h2 class="text-center">Jadwal Praktikulum</h2>
            <div class="table-responsive">
                <table id="jadwalTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tanggals->reverse() as $tanggal)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($tanggal->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
                                <td>
                                    <button type="button" class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#myModal{{ $tanggal->id_tanggal }}">
                                        Detail
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Modal untuk Detail Jadwal -->
                            <div class="modal fade" id="myModal{{ $tanggal->id_tanggal }}" tabindex="-1" aria-labelledby="myModalLabel{{ $tanggal->id_tanggal }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel{{ $tanggal->id_tanggal }}">Detail Jadwal</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Sesi 1 -->
                                            <h4>Sesi 1</h4>
                                            @php
                                                $sesi1Available = false;
                                            @endphp
                                            @foreach ($jadwals as $sesi)
                                                @if ($sesi->sesi == 1 && $sesi->id_tanggal == $tanggal->id_tanggal)
                                                    <div class="row">
                                                        <div class="col-md-4">Waktu Mulai</div>
                                                        <div class="col-md-5">: {{ $sesi->waktu_mulai }}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">Waktu Selesai</div>
                                                        <div class="col-md-5">: {{ $sesi->waktu_selesai }}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">Kuota</div>
                                                        <div class="col-md-5">: {{ $sesi->kuota }}</div>
                                                    </div>
                                                    @php
                                                        $sesi1Available = true;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @if (!$sesi1Available)
                                                <div class="row">
                                                    <div class="col-md-12">Sesi belum tersedia</div>
                                                </div>
                                            @endif

                                            <!-- Sesi 2 -->
                                            <h4>Sesi 2</h4>
                                            @php
                                                $sesi2Available = false;
                                            @endphp
                                            @foreach ($jadwals as $sesi)
                                                @if ($sesi->sesi == 2 && $sesi->id_tanggal == $tanggal->id_tanggal)
                                                    <div class="row">
                                                        <div class="col-md-4">Waktu Mulai</div>
                                                        <div class="col-md-5">: {{ $sesi->waktu_mulai }}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">Waktu Selesai</div>
                                                        <div class="col-md-5">: {{ $sesi->waktu_selesai }}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">Kuota</div>
                                                        <div class="col-md-5">: {{ $sesi->kuota }}</div>
                                                    </div>
                                                    @php
                                                        $sesi2Available = true;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @if (!$sesi2Available)
                                                <div class="row">
                                                    <div class="col-md-12">Sesi belum tersedia</div>
                                                </div>
                                            @endif

                                            <!-- Sesi 3 -->
                                            <h4>Sesi 3</h4>
                                            @php
                                                $sesi3Available = false;
                                            @endphp
                                            @foreach ($jadwals as $sesi)
                                                @if ($sesi->sesi == 3 && $sesi->id_tanggal == $tanggal->id_tanggal)
                                                    <div class="row">
                                                        <div class="col-md-4">Waktu Mulai</div>
                                                        <div class="col-md-5">: {{ $sesi->waktu_mulai }}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">Waktu Selesai</div>
                                                        <div class="col-md-5">: {{ $sesi->waktu_selesai }}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">Kuota</div>
                                                        <div class="col-md-5">: {{ $sesi->kuota }}</div>
                                                    </div>
                                                    @php
                                                        $sesi3Available = true;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @if (!$sesi3Available)
                                                <div class="row">
                                                    <div class="col-md-12">Sesi belum tersedia</div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            {{-- <form action="{{ route('data.hapus', $tanggal->id_tanggal) }}" method="POST"> --}}
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <a href="/datatanggal" class="btn btn-danger">&lt; Back</a>
                <a href="/datajadwal" class="btn btn-warning">Next &gt;</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#jadwalTable').DataTable({
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ entri",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                    "infoFiltered": "(disaring dari _MAX_ total entri)",
                    "zeroRecords": "Tidak ada data yang cocok",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });
        });
    </script>
</body>
</html>
