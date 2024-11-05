@extends('layout.dash')
@section('content')
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIM</th>
                <th>Ruangan</th>
                <th>Penanggung Jawab</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mahasiswas as $mahasiswa)
                <tr>
                    <td>{{ $mahasiswa->nama }}</td>
                    <td>{{ $mahasiswa->nim }}</td>
                    <td>
                        @if ($mahasiswa->ruangan)
                            {{ $mahasiswa->ruangan->ruangan }}
                        @else
                            <button onclick="showModal('ruangan', '{{ $mahasiswa->nim }}')">Tambah</button>
                        @endif
                    </td>
                    <td>
                        @if ($mahasiswa->penanggungJawab)
                            {{ $mahasiswa->penanggungJawab->penanggung_jawab }}
                        @else
                            <button onclick="showModal('penanggungJawab', '{{ $mahasiswa->nim }}')">Tambah</button>
                        @endif
                    </td>
                </tr>
                <div id="modal" style="display: none;">
                    <form id="form">
                        <input type="hidden" name="nim" id="nim">
                        <input type="text" name="value" id="value" placeholder="Masukkan data">
                        <button type="button" onclick="submitForm()">Kirim</button>
                    </form>
                </div>
            @endforeach
        </tbody>
    </table>
    <script>
        function showModal(type, nim) {
            document.getElementById('modal').style.display = 'block';
            document.getElementById('nim').value = nim;
            document.getElementById('form').dataset.type = type;
        }

        function submitForm() {
            const nim = document.getElementById('nim').value;
            const value = document.getElementById('value').value;
            const type = document.getElementById('form').dataset.type;

            fetch(`/mahasiswa/tambah-${type}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        nim,
                        value
                    })
                }).then(response => response.json())
                .then(data => location.reload());
        }
    </script>
@endsection
