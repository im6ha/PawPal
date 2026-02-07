<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('/css/other-pages/admin-dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/components/cards.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="icon" type="image/png" href="{{ asset('../media/images/logo-brand.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <header class="admin-header">
        <a href="{{ url('/') }}" class="logo-link">
            <img src="{{ asset('../media/images/logo-brand.png') }}" alt="Logo" class="admin-logo" />
        </a>
        <h1><i class="fas fa-shield-alt"></i> Admin Dashboard</h1>
    </header>

    <main class="admin-main">
        <div class="stats-overview">
            <div class="stat-card">
                <div class="stat-icon bg-primary">
                    <i class="fas fa-paw"></i>
                </div>
                <div class="stat-info">
                    <h3 id="total-posts-count">0</h3>
                    <p>Total Posts</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-secondary">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-info">
                    <h3 id="active-reports-count">0</h3>
                    <p>Reports</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bg-accent">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3 id="active-users-count">0</h3>
                    <p>Active Users</p>
                </div>
            </div>

        </div>

        <div class="admin-tabs">
            <button class="tab-btn active" data-tab="posts">
                <i class="fas fa-clipboard-list"></i> Posts
            </button>
            <button class="tab-btn" data-tab="reports">
                <i class="fas fa-exclamation-circle"></i> Reports
            </button>
            <button class="tab-btn" data-tab="users">
                <i class="fas fa-users-cog"></i> Users
            </button>
        </div>

        <div id="posts" class="tab-content active">
            <div class="sub-tabs">
                <button class="sub-tab-btn active" data-subtab="accepted">
                    Accepted Posts
                </button>
                <button class="sub-tab-btn" data-subtab="requested">
                    Requested Posts
                </button>
            </div>

            <div id="accepted-posts" class="sub-tab-content active">
                <div class="post-type-tabs">
                    <button class="post-type-btn active" data-type="adoption">Adoption</button>
                    <button class="post-type-btn" data-type="products">Products</button>
                    <button class="post-type-btn" data-type="sitters">Sitters</button>
                    <button class="post-type-btn" data-type="lost-pets">Lost Pets</button>
                </div>

                <div class="post-type-contents">
                    <div id="accepted-adoption" class="post-type-content active">
                        <div class="cards-grid" id="accepted-adoption-grid"></div>
                    </div>
                    <div id="accepted-products" class="post-type-content">
                        <div class="cards-grid" id="accepted-products-grid"></div>
                    </div>
                    <div id="accepted-sitters" class="post-type-content">
                        <div class="cards-grid" id="accepted-sitters-grid"></div>
                    </div>
                    <div id="accepted-lost-pets" class="post-type-content">
                        <div class="cards-grid" id="accepted-lost-pets-grid"></div>
                    </div>
                </div>
            </div>

            <div id="requested-posts" class="sub-tab-content">
                <div class="post-type-tabs">
                    <button class="post-type-btn active" data-type="adoption">Adoption</button>
                    <button class="post-type-btn" data-type="products">Products</button>
                    <button class="post-type-btn" data-type="sitters">Sitters</button>
                    <button class="post-type-btn" data-type="lost-pets">Lost Pets</button>
                </div>

                <div class="post-type-contents">
                    <div id="requested-adoption" class="post-type-content active">
                        <div class="cards-grid" id="requested-adoption-grid"></div>
                    </div>
                    <div id="requested-products" class="post-type-content">
                        <div class="cards-grid" id="requested-products-grid"></div>
                    </div>
                    <div id="requested-sitters" class="post-type-content">
                        <div class="cards-grid" id="requested-sitters-grid"></div>
                    </div>
                    <div id="requested-lost-pets" class="post-type-content">
                        <div class="cards-grid" id="requested-lost-pets-grid"></div>
                    </div>
                </div>
            </div>
        </div>

        <div id="reports" class="tab-content">
            <div class="report-type-tabs">
                <button class="report-type-btn active" data-type="adoption">Adoption Reports</button>
                <button class="report-type-btn" data-type="products">Product Reports</button>
                <button class="report-type-btn" data-type="sitters">Sitter Reports</button>
                <button class="report-type-btn" data-type="lost-pets">Lost Pets Reports</button>
            </div>

            <div class="report-type-contents">
                <div id="reports-adoption" class="report-type-content active">
                    <div class="reports-list" id="reports-adoption-list"></div>
                </div>
                <div id="reports-products" class="report-type-content">
                    <div class="reports-list" id="reports-products-list"></div>
                </div>
                <div id="reports-sitters" class="report-type-content">
                    <div class="reports-list" id="reports-sitters-list"></div>
                </div>
                <div id="reports-lost-pets" class="report-type-content">
                    <div class="reports-list" id="reports-lost-pets-list"></div>
                </div>
            </div>
        </div>

        <div id="users" class="tab-content">
            <div class="users-header">
                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="user-search" placeholder="Search users by name, ID, or email..." />
                </div>
                <div class="filter-container">
                    <select id="user-filter">
                        <option value="all">All Users</option>
                        <option value="trusted">Trusted (8-10)</option>
                        <option value="normal">Normal (5-7)</option>
                        <option value="suspicious">Suspicious (1-4)</option>
                        <option value="banned">Banned</option>
                    </select>
                </div>
            </div>
            <div class="users-grid" id="users-grid"></div>
        </div>
    </main>

    <div id="action-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modal-title">Confirm Action</h2>
            <p id="modal-message">Are you sure you want to perform this action?</p>
            <div class="modal-buttons">
                <button id="confirm-btn" class="btn-confirm">Confirm</button>
                <button id="cancel-btn" class="btn-cancel">Cancel</button>
            </div>
        </div>
    </div>

    <script type="module" src="{{ asset('/js/other-scripts/admin-dashboard.js') }}"></script>
</body>

</html>
