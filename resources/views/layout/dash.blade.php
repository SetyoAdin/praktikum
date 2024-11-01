<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Universitas Muhammadiyah</title>
    <link rel="icon" href="/UMMLOGO.png" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* === Reset & Base Styles === */
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --text-color: #333;
            --bg-color: #f5f6fa;
            --white: #ffffff;
            --shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
            --sidebar-width: 250px;
            --header-height: 60px;
            --footer-height: 50px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* === Layout Structure === */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* === Sidebar Styles === */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--primary-color);
            color: var(--white);
            transition: var(--transition);
            height: 100vh;
            position: fixed;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid var(--secondary-color);
            height: var(--header-height);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-logo {
            font-size: 1.5rem;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-section {
            margin-bottom: 1rem;
        }

        .menu-section-title {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #b3b3b3;
        }

        .menu-item {
            padding: 0.8rem 1rem;
            display: flex;
            align-items: center;
            transition: var(--transition);
        }

        .menu-item:hover {
            background: var(--secondary-color);
            border-left: 4px solid var(--white);
        }

        .menu-item i {
            width: 20px;
            margin-right: 10px;
            font-size: 1.1rem;
        }

        /* === Main Content Area === */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* === Header Styles === */
        .header {
            height: var(--header-height);
            background: var(--white);
            padding: 0 2rem;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            right: 0;
            left: var(--sidebar-width);
            z-index: 100;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .toggle-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--primary-color);
            display: none;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .user-profile img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
        }

        /* === Content Wrapper === */
        .content-wrapper {
            padding: calc(var(--header-height) + 2rem) 2rem var(--footer-height) 2rem;
            min-height: calc(100vh - var(--footer-height));
            background: var(--bg-color);
        }

        /* === Footer === */
        .footer {
            height: var(--footer-height);
            background: var(--white);
            padding: 1rem 2rem;
            text-align: center;
            box-shadow: var(--shadow);
            margin-top: auto;
        }

        /* === Responsive Design === */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1000;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .header {
                left: 0;
            }

            .toggle-btn {
                display: block;
            }

            .content-wrapper {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }

        /* === Utilities === */
        .badge {
            background: #e74c3c;
            color: white;
            padding: 0.2rem 0.5rem;
            border-radius: 10px;
            font-size: 0.8rem;
        }

        /*CSS ALERT*/
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #3498db;
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            z-index: 1000;
            opacity: 1;
            transition: opacity 0.5s ease;
        }

        .alert.hide {
            opacity: 0;
            pointer-events: none;
        }

        .alert .progress-bar {
            height: 4px;
            width: 100%;
            background-color: #2980b9;
            margin-top: 5px;
            border-radius: 2px;
            transition: width 6s linear;
        }

        /*CSS PROFILE POJOK KANAN ATAS*/
        .header-right {
            display: flex;
            align-items: center;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-profile a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }

        .user-initial {
            width: 40px;
            height: 40px;
            background: #e0f2fe;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 600;
            color: #0284c7;
            text-decoration: none;
        }

        /*CSS MATKUL*/
        body {
            background-color: #f5f5f5;
            font-family: 'Open Sans', sans-serif;
        }

        .page-title {
            color: #2c3e50;
            margin: 30px 0;
            font-weight: 900;
            font-size: 2.5rem;
            text-align: center;
        }

        .form-container {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 30px;
        }

        .form-section {
            margin-bottom: 20px;
        }

        .form-section-title {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #2c3e50;
        }

        .table-container {
            margin-top: 40px;
        }

        .table-card {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .table {
            min-width: 100%;
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #2c3e50;
            color: #ffffff;
            border: none;
            white-space: nowrap;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .table-container {
            margin-bottom: 40px;
            /* Adds space below each table container */
        }

        /* Update the table-card style */
        .table-card {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 40px;
            /* Adds space below each table card */
        }


        .current-table-title {
            display: inline-block;
            margin-left: 15px;
            font-weight: 700;
            color: #2c3e50;
        }

        .card-title {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #2c3e50;
        }

        .btn-custom {
            background-color: #2c3e50;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .btn-custom:hover {
            background-color: #34495e;
            color: #ffffff;
        }

        .form-control,
        .form-select {
            border: 1px solid #2c3e50;
            border-radius: 5px;
            padding: 10px 15px;
        }

        /* Responsive Design */
        @media (min-width: 992px) {
            .form-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
            }

            .form-section {
                flex: 0 0 calc(33.333% - 20px);
            }
        }

        @media (max-width: 991px) {
            .form-section {
                flex: 0 0 100%;
                margin-bottom: 30px;
            }

            .page-title {
                font-size: 2rem;
            }

            .form-container {
                padding: 15px;
            }
        }

        @media (max-width: 768px) {
            .table-card {
                padding: 15px;
            }

            .card-title {
                font-size: 1.5rem;
            }

            .table thead th {
                font-size: 0.9rem;
            }

            .table tbody td {
                font-size: 0.9rem;
            }

            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.875rem;
            }
        }

        .icon-button {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            color: #000;
            text-decoration: none !important;
        }

        .icon-button i {
            font-size: 1.2em;
        }


        .trash-icon {
            font-size: 1.2em;
            color: red;
            margin-right: 10px;
        }


        .edit-icon {
            color: green;
            margin-right: 8px;
        }


        table td:nth-child(3) {
            width: 100px;
            text-align: center;
        }


        .icon-button:hover {
            color: #007bff;
        }

        .modal-dialog {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) !important;
            margin: 0;
            width: 60vw !important;
            max-width: 800px !important;
            height: 80vh;
        }

        .modal-content {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .modal-body {
            flex: 1;
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .modal-dialog {
                /* Mengubah dari 95vw menjadi 90vw untuk mobile */
                height: 90vh;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .modal-dialog {
                width: 75vw !important;
            }
        }

        .btn-kembali {
            background-color: #2c3e50;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .btn-kembali:hover {
            background-color: #34495e;
            color: white;
        }


        .modal-footer {
            padding: 1rem;
            border-top: 1px solid #dee2e6;
            background: white;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">AdminDash</div>
            </div>
            <nav class="sidebar-menu">
                <div class="menu-section">
                    <div class="menu-section-title">Main</div>
                    <a href="/dashboard" class="menu-item">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                    {{-- <a href="analytics.html" class="menu-item">
                        <i class="fas fa-chart-bar"></i>
                        <span>Analytics</span>
                    </a> --}}
                </div>

                <div class="menu-section">
                    <div class="menu-section-title">Management</div>

                    <a href="/registeradmin" class="menu-item"
                        @if (auth()->user()->role !== 'super') style="display: none;" @endif>
                        <i class="fas fa-users"></i>
                        <span>Admin</span>
                    </a>
                    {{-- <a href="products.html" class="menu-item">
                        <i class="fas fa-box"></i>
                        <span>Products</span>
                    </a> --}}
                    <a href="/matkul" class="menu-item">

                        <i class="fas fa-table"></i>
                        <span>Manajemen Jadwal</span>
                    </a>
                </div>

                <div class="menu-section">
                    <div class="menu-section-title">Settings</div>
                    <a href="/profile" class="menu-item">
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                    {{-- <a href="settings.html" class="menu-item">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a> --}}
                    <a href="/ummadmin" class="menu-item" onclick="logout()">
                        <i class="fas fa-sign-out-alt"></i> <!-- Ikon untuk logout -->
                        <span>Logout</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="header-left">
                    <button class="toggle-btn" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2>Dashboard</h2>
                </div>
                <div class="header-right">
                    <div class="user-profile">
                        <a href="#" class="d-block">{{ Auth::user()->nama }}</a>
                        <div class="user-initial">
                            {{ strtoupper(substr(Auth::user()->nama, 0, 2)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Wrapper -->
            <main class="content-wrapper">
                <div id="pageContent">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="footer">
                <p>&copy; 2024 AdminDash. All rights reserved.</p>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');

            // Sidebar Toggle
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });

            // Close sidebar when clicking outside (mobile)
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(event.target) &&
                        !sidebarToggle.contains(event.target)) {
                        sidebar.classList.remove('active');
                    }
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('active');
                }
            });
        });
    </script>
</body>

</html>
