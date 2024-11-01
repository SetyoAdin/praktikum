@extends('layout.dash')

@section('content')
    <style>
        .usr-profile-container {
            max-width: 700px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .usr-profile-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .usr-profile-header {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .usr-avatar-circle {
            width: 96px;
            height: 96px;
            background: #e0f2fe;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 600;
            color: #0284c7;
        }

        .usr-profile-details {
            flex: 1;
        }

        .usr-profile-name {
            font-size: 1.5rem;
            color: #1e293b;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .usr-profile-email {
            color: #64748b;
        }

        .usr-profile-section {
            border-top: 1px solid #e2e8f0;
            padding-top: 1.5rem;
            margin-top: 1.5rem;
        }

        .usr-section-title {
            font-size: 1.25rem;
            color: #1e293b;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .usr-info-row {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            position: relative;
        }

        .usr-info-icon {
            width: 20px;
            height: 20px;
            color: #64748b;
            flex-shrink: 0;
        }

        .usr-info-content {
            flex: 1;
        }

        .usr-info-label {
            font-size: 0.875rem;
            color: #64748b;
            margin-bottom: 0.25rem;
        }

        .usr-info-value {
            color: #1e293b;
        }

        .usr-settings-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.5rem 0;
        }

        .usr-settings-info {
            flex: 1;
        }

        .usr-settings-title {
            color: #1e293b;
            margin-bottom: 0.25rem;
            font-weight: 500;
        }

        .usr-settings-desc {
            font-size: 0.875rem;
            color: #64748b;
        }

        .usr-profile-btn {
            background: #f1f5f9;
            color: #475569;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
            transition: background-color 0.2s;
        }

        .usr-profile-btn:hover {
            background: #e2e8f0;
        }

        @media (max-width: 640px) {
            .usr-profile-header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .usr-avatar-circle {
                margin: 0 auto;
            }
        }

        .usr-edit-icon {
            width: 20px;
            height: 20px;
            cursor: pointer;
            margin-left: 8px;
            color: #64748b;
            display: inline-block;
            vertical-align: middle;
        }

        .usr-edit-icon:hover {
            color: #0284c7;
        }

        .usr-info-input {
            font-size: inherit;
            padding: 4px 8px;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            width: 100%;
            max-width: 250px;
        }

        .usr-info-input:focus {
            outline: none;
            border-color: #0284c7;
            box-shadow: 0 0 0 1px #0284c7;
        }

        .usr-edit-form {
            display: none;
        }

        .usr-edit-form.active {
            display: block;
        }

        .usr-name-display {
            display: flex;
            align-items: center;
        }

        .usr-name-display.hidden {
            display: none;
        }

        /* Animasi loading */
        .usr-loading {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #0284c7;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 8px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <div class="usr-profile-container">
        <div class="usr-profile-card">
            <div class="usr-profile-header">
                <div class="usr-avatar-circle">
                    {{ strtoupper(substr(auth()->user()->nama, 0, 2)) }}
                </div>
                <div class="usr-profile-details">
                    <h1 class="usr-profile-name">{{ auth()->user()->nama }}</h1>
                    <p class="usr-profile-email">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <div class="usr-profile-section">
                <h2 class="usr-section-title">Account Info</h2>

                <div class="usr-info-row">
                    <svg class="usr-info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <div class="usr-info-content">
                        <p class="usr-info-label">Name</p>

                        <!-- Tampilan nama -->
                        <div class="usr-name-display">
                            <p class="usr-info-value">{{ auth()->user()->nama }}</p>
                            <svg class="usr-edit-icon edit-btn" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            <div class="usr-loading"></div>
                        </div>

                        <!-- Form edit -->
                        <div class="usr-edit-form">
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <input type="text" class="usr-info-input" value="{{ auth()->user()->nama }}">
                                <svg class="usr-edit-icon save-btn" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="usr-info-row">
                    <svg class="usr-info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <div class="usr-info-content">
                        <p class="usr-info-label">Email</p>
                        <p class="usr-info-value">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>

            @if (auth()->user()->role !== 'super_admin')
                <div class="usr-profile-section">
                    <h2 class="usr-section-title">Settings</h2>
                    <div class="usr-settings-row">
                        <div class="usr-settings-info">
                            <h3 class="usr-settings-title">Security Settings</h3>
                            <p class="usr-settings-desc">Update your password and security preferences</p>
                        </div>
                        <button class="usr-profile-btn">Update</button>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameDisplay = document.querySelector('.usr-name-display');
            const editForm = document.querySelector('.usr-edit-form');
            const editBtn = document.querySelector('.edit-btn');
            const saveBtn = document.querySelector('.save-btn');
            const nameInput = document.querySelector('.usr-info-input');
            const nameValue = document.querySelector('.usr-info-value');
            const loading = document.querySelector('.usr-loading');

            // Token CSRF
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            editBtn.addEventListener('click', function() {
                nameDisplay.classList.add('hidden');
                editForm.classList.add('active');
                nameInput.value = nameValue.textContent.trim();
                nameInput.focus();
            });

            saveBtn.addEventListener('click', updateName);
            nameInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    updateName();
                }
            });

            function updateName() {
                const newName = nameInput.value.trim();

                if (!newName) return;

                // Tampilkan loading
                loading.style.display = 'inline-block';
                editForm.classList.remove('active');

                fetch('/profile/update-name', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            nama: newName
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            nameValue.textContent = data.nama;
                            nameDisplay.classList.remove('hidden');
                        } else {
                            alert('Failed to update name');
                            editForm.classList.add('active');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while updating name');
                        editForm.classList.add('active');
                    })
                    .finally(() => {
                        loading.style.display = 'none';
                    });
            }
        });
    </script>
@endsection
