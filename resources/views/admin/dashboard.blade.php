@extends('layout.dash')
@section('content')
    <style>
        :root {
            --secondary-color: #f5f6fa;
            --text-color: #2c3e50;
            --border-color: #e1e8ed;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text-color);
            line-height: 1.6;
            background-color: #f8f9fd;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        /* Content wrapper */
        .content-wrapper {
            padding: 1.5rem;
            min-height: calc(100vh - 3rem);
            /* Account for padding */
            display: flex;
            flex-direction: column;
        }

        /* Main card container */
        .content-wrapper {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow);
            margin: 1rem;
        }

        /* Section styles */
        .section {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .section:last-child {
            border-bottom: none;
        }

        .section-title {
            font-size: 1.5rem;
            color: var(--text-color);
            margin-bottom: 1.5rem;
            font-weight: 600;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 40px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        /* Cards grid */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .card {
            background: var(--secondary-color);
            padding: 1.5rem;
            border-radius: 8px;
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        .card h3 {
            font-size: 0.9rem;
            color: #718096;
            margin: 0 0 0.5rem 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .card p {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--text-color);
            margin: 0;
        }

        /* Chart container */
        .chart-container {
            width: 100%;
            height: 400px;
            position: relative;
            margin-top: 1rem;
            background: var(--secondary-color);
            border-radius: 8px;
            padding: 1rem;
        }

        /* Table styles */
        .table-container {
            margin-top: 1rem;
            background: var(--secondary-color);
            border-radius: 8px;
            padding: 1rem;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            font-weight: 600;
            color: var(--text-color);
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background-color: rgba(74, 144, 226, 0.04);
        }

        /* Status styles */
        td:nth-child(3) {
            font-weight: 500;
        }

        td:nth-child(3):contains("Active") {
            color: var(--success-color);
        }

        td:nth-child(3):contains("Inactive") {
            color: var(--danger-color);
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .content-wrapper {
                margin: 0.5rem;
            }

            .section {
                padding: 1rem;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .chart-container {
                height: 300px;
            }

            table {
                font-size: 0.9rem;
            }

            th,
            td {
                padding: 0.75rem;
            }
        }

        /* Sweet Alert customization */
        .swal2-popup.swal2-toast {
            background: white;
            box-shadow: var(--shadow);
            border-radius: 8px;
        }

        .swal2-title {
            color: var(--text-color) !important;
            font-size: 1rem !important;
        }

        .swal2-timer-progress-bar {
            background: var(--primary-color) !important;
        }

        /* Additional spacing adjustments */
        #overview,
        #data,
        #table {
            margin-bottom: 0;
        }

        /* Smooth scrolling for the entire page */
        html {
            scroll-behavior: smooth;
        }
    </style>

    <body>
        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Alert -->
            @if (session('user_name'))
                <script>
                    // Set userName to localStorage for SweetAlert
                    localStorage.setItem('welcomeUser', '{{ session('user_name') }}');
                </script>
            @endif

            <section id="overview" class="section">
                <h2 class="section-title">Overview</h2>
                <div class="cards">
                    <div class="card">
                        <h3>Users</h3>
                        <p>1500</p>
                    </div>
                    <div class="card">
                        <h3>Revenue</h3>
                        <p>$5,200</p>
                    </div>
                    <div class="card">
                        <h3>New Orders</h3>
                        <p>300</p>
                    </div>
                </div>
            </section>

            <!-- Chart Section -->
            <section id="data" class="section">
                <h2 class="section-title">Data Visualization</h2>
                <div class="chart-container">
                    <canvas id="myChart"></canvas>
                </div>
            </section>

            <!-- Table Section -->
            <section id="table" class="section">
                <h2 class="section-title">Data Table</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>John Doe</td>
                                <td>Active</td>
                                <td>$120</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Jane Smith</td>
                                <td>Inactive</td>
                                <td>$80</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
            @if (session('login_success'))
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const userName = '{{ session('user_name') }}';
                        Swal.fire({
                            title: `Selamat datang, ${userName}!`,
                            position: 'top-end',
                            toast: true,
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 6000, // Durasi alert (6 detik)
                            timerProgressBar: true, // Menampilkan indikator garis
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer); // Pause timer saat hover
                                toast.addEventListener('mouseleave', Swal
                                    .resumeTimer); // Lanjutkan timer saat mouse leave
                            }
                        });
                    });
                </script>
            @endif
        </div>
        <script src="script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </body>
@endsection
