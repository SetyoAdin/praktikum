<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LabPraktikum - Pendaftaran Praktikum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #1a237e;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
        }

        .navbar-brand,
        .nav-link {
            color: #ffffff !important;
        }

        .hero-section {
            background: linear-gradient(rgba(26, 35, 126, 0.7), rgba(26, 35, 126, 0.7)), url('/api/placeholder/1200/600');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .btn-register {
            background-color: #ff4081;
            border-color: #ff4081;
            padding: 10px 30px;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            background-color: #f50057;
            border-color: #f50057;
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #3f51b5;
        }

        .table-schedule {
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table-schedule thead {
            background-color: #3f51b5;
            color: white;
        }

        .footer {
            background-color: #1a237e;
            color: #ffffff;
            padding: 20px 0;
        }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s, transform 0.5s;
        }

        .animate-on-scroll.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-flask me-2"></i>LabPraktikum</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#schedule">Jadwal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="container">
            <h1 class="display-4 mb-4">Pendaftaran Praktikum Online</h1>
            <p class="lead mb-5">Daftar praktikum dengan mudah dan cepat. Tingkatkan keterampilan laboratorium Anda
                bersama kami!</p>
            <a href="/form" class="btn btn-register btn-lg">Daftar Sekarang</a>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5" id="about">
        <div class="container">
            <h2 class="text-center mb-5">Mengapa Memilih Kami?</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-graduation-cap feature-icon"></i>
                            <h5 class="card-title">Pembelajaran Berkualitas</h5>
                            <p class="card-text">Dapatkan pengalaman praktikum dengan standar akademik tinggi dan
                                fasilitas modern.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-users feature-icon"></i>
                            <h5 class="card-title">Pembimbing Ahli</h5>
                            <p class="card-text">Dibimbing oleh para ahli di bidangnya untuk memaksimalkan pemahaman
                                Anda.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-clock feature-icon"></i>
                            <h5 class="card-title">Fleksibilitas Waktu</h5>
                            <p class="card-text">Pilih jadwal yang sesuai dengan kebutuhan Anda dari berbagai pilihan
                                yang tersedia.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Schedule Section -->
    <section class="py-5 bg-light" id="schedule">
        <div class="container">
            <h2 class="text-center mb-5">Jadwal Praktikum</h2>
            <div class="table-responsive">
                <table class="table table-hover table-schedule animate-on-scroll">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-3 px-4 text-center border-b">No</th>
                            <th class="py-3 px-6 text-left border-b">Mata Kuliah</th>
                            <th class="py-3 px-6 text-left border-b">Tanggal</th>
                            <th class="py-3 px-6 text-left border-b">Sesi</th>
                            <th class="py-3 px-6 text-left border-b">Waktu</th>
                            <th class="py-3 px-6 text-center border-b">Kuota</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($mataKuliahs as $matkul)
                            @foreach ($matkul->tanggals as $index => $tanggal)
                                @foreach ($tanggal->jadwals as $jadwalIndex => $jadwal)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4 text-center border-b">{{ $no++ }}</td>
                                        @if ($index === 0 && $jadwalIndex === 0)
                                            <td class="py-3 px-6 border-b"
                                                rowspan="{{ $matkul->tanggals->sum(function ($tanggal) {return $tanggal->jadwals->count();}) }}">
                                                {{ $matkul->matkul }}
                                            </td>
                                        @endif
                                        @if ($jadwalIndex === 0)
                                            <td class="py-3 px-6 border-b" rowspan="{{ $tanggal->jadwals->count() }}">
                                                {{ \Carbon\Carbon::parse($tanggal->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                            </td>
                                        @endif
                                        <td class="py-3 px-6 border-b">{{ $jadwal->sesi }}</td>
                                        <td class="py-3 px-6 border-b">
                                            {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }}-
                                            {{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}</td>
                                        <td class="py-3 px-6 text-center border-b">
                                            @php
                                                $kuotaPercentage = ($jadwal->kuota / 40) * 100; // Asumsi kuota maksimal 40
                                                $statusClass = '';
                                                $statusText = '';

                                                if ($jadwal->kuota <= 0) {
                                                    $statusClass = 'bg-red-100 text-red-800';
                                                    $statusText = 'Habis';
                                                } elseif ($jadwal->kuota <= 5) {
                                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                                    $statusText = 'Terbatas';
                                                } else {
                                                    $statusClass = 'bg-green-100 text-green-800';
                                                    $statusText = 'Tersedia';
                                                }
                                            @endphp
                                            <div class="flex items-center justify-center">
                                                <span class="px-2 py-1 rounded text-sm {{ $statusClass }}">
                                                    {{ $jadwal->kuota }} ({{ $statusText }})
                                                </span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                                <div class="rounded-full h-2 
                                                    @if ($jadwal->kuota <= 0) bg-red-500
                                                    @elseif($jadwal->kuota <= 10) bg-yellow-500
                                                    @else bg-green-500 @endif"
                                                    style="width: {{ $kuotaPercentage }}%">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h2 class="mb-4">Siap untuk Memulai Perjalanan Praktikum Anda?</h2>
            <p class="lead mb-4">Daftar sekarang dan tingkatkan keterampilan laboratorium Anda bersama kami!</p>
            <a href="#" class="btn btn-light btn-lg">Daftar Sekarang</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <span>&copy; 2024 LabPraktikum. Hak Cipta Dilindungi.</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Smooth scrolling for anchor links
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if (target.length) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 70
                    }, 1000);
                }
            });

            // Navbar background change on scroll
            $(window).scroll(function() {
                if ($(this).scrollTop() > 50) {
                    $('.navbar').addClass('bg-dark');
                } else {
                    $('.navbar').removeClass('bg-dark');
                }
            });

            // Animation for elements on scroll
            function animateOnScroll() {
                $('.animate-on-scroll').each(function() {
                    var elementPos = $(this).offset().top;
                    var topOfWindow = $(window).scrollTop();
                    var windowHeight = $(window).height();
                    if (elementPos < topOfWindow + windowHeight - 50) {
                        $(this).addClass('show');
                    }
                });
            }

            // Run animation on load and scroll
            animateOnScroll();
            $(window).scroll(animateOnScroll);
        });
    </script>
</body>

</html>
