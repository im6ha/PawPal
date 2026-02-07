<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('/css/other-pages/profile.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('media/images/logo-brand.png') }}" />
</head>
<body>
    <header class="profile-header">
        <a href="{{ url('/') }}" class="logo-link">
            <img src="{{ asset('media/images/logo-brand.png') }}" alt="Logo" class="profile-logo">
        </a>
        <h1><i class="fas fa-user"></i> My Profile</h1>
        <div class="header-actions">
            <a href="{{ url('user-dashboard') }}" class="dashboard-link">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </div>
    </header>

    <main class="profile-main">
        <div class="profile-container">
            <div class="profile-card">
                <div class="avatar-section">
                    <div class="avatar-container" id="avatar-display">
                        @if(auth()->user()->profile_image)
                            <img src="{{ asset(auth()->user()->profile_image) }}" style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                        @else
                            <div class="avatar-initial">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                        @endif
                        <label for="avatar-input" class="avatar-edit">
                            <i class="fas fa-camera"></i>
                            <input type="file" id="avatar-input" accept="image/*" hidden>
                        </label>
                    </div>
                    <h2 class="user-name">{{ auth()->user()->name }}</h2>
                </div>
                <div class="info-section">
                    <h3><i class="fas fa-info-circle"></i> Personal Information</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <label for="full-name">Full Name</label>
                            <div class="input-with-icon">
                                <i class="fas fa-user"></i>
                                <input type="text" id="full-name" value="{{ auth()->user()->name }}" readonly>
                                <button class="edit-btn" data-field="full-name">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                        <div class="info-item">
                            <label for="email">Email Address</label>
                            <div class="input-with-icon">
                                <i class="fas fa-envelope"></i>
                                <input type="email" id="email" value="{{ auth()->user()->email }}" readonly>
                                <button class="edit-btn" data-field="email">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                        <div class="info-item">
                            <label for="phone">Phone Number</label>
                            <div class="input-with-icon">
                                <i class="fas fa-phone"></i>
                                <input type="tel" id="phone" value="{{ auth()->user()->phone }}" readonly>
                                <button class="edit-btn" data-field="phone">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="save-section">
                        <button id="save-changes" class="save-btn">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </div>

                <div class="account-section">
                    <h3><i class="fas fa-cog"></i> Account Settings</h3>
                    <div class="account-actions">
                        <button class="action-btn">
                            <i class="fas fa-lock"></i>
                            <span>Change Password</span>
                        </button>
                        <button class="action-btn danger">
                            <i class="fas fa-user-times"></i>
                            <span>Delete Account</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="edit-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modal-title">Edit Information</h2>
            <div class="modal-body">
                <label for="modal-field">Field Value</label>
                <input type="text" id="modal-field" class="modal-input">
            </div>
            <div class="modal-buttons">
                <button id="modal-cancel" class="btn-cancel">Cancel</button>
                <button id="modal-save" class="btn-save">Save Changes</button>
            </div>
        </div>
    </div>

    <div id="password-modal" class="modal">
        <div class="modal-content">
            <span class="close-pw">&times;</span>
            <h2><i class="fas fa-lock"></i> Change Password</h2>
            <div class="modal-body">
                <div class="info-item">
                    <label>Current Password</label>
                    <input type="password" id="current-pw" class="modal-input">
                </div>
                <div class="info-item">
                    <label>New Password</label>
                    <input type="password" id="new-pw" class="modal-input">
                </div>
                <div class="info-item">
                    <label>Confirm New Password</label>
                    <input type="password" id="confirm-pw" class="modal-input">
                </div>
            </div>
            <div class="modal-buttons">
                <button id="pw-cancel" class="btn-cancel">Cancel</button>
                <button id="pw-save" class="btn-save">Update Password</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('/js/other-scripts/profile.js') }}" type="module"></script>
</body>
</html>