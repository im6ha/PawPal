<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Dashboard</title>
    <link rel="stylesheet" href="{{ asset('/css/components/cards.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/other-pages/user-dashboard.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="icon" type="image/png" href="{{ asset('../media/images/logo-brand.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .saved-card .save-icon-wrapper svg,
        .saved-card .card-icon-btn.save svg {
            fill: #1d4ed8 !important;
        }

        .my-post-card:hover {
            transform: scale(1.02) translateY(-3px);
        }
    </style>
</head>

<body>
    <header class="dashboard-header">
        <a href="{{ url('/') }}" class="logo-link">
            <img src="{{ asset('../media/images/logo-brand.png') }}" alt="Logo" class="dashboard-logo" />
        </a>
        <h1><i class="fas fa-user-circle"></i> User Dashboard</h1>

    </header>

    <main class="dashboard-main">
        <div class="stats-overview">
            <div class="stat-card" data-stat-type="saved">
                <div class="stat-icon bg-primary">
                    <i class="fas fa-heart"></i>
                </div>
                <div class="stat-info">
                    <h3 id="stat-saved-count">0</h3>
                    <p>Saved Items</p>
                </div>
            </div>
            <div class="stat-card" data-stat-type="my-requests">
                <div class="stat-icon bg-secondary">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div class="stat-info">
                    <h3 id="stat-requests-count">0</h3>
                    <p>My Requests Sent</p>
                </div>
            </div>
            <div class="stat-card" data-stat-type="incoming-requests">
                <div class="stat-icon bg-accent">
                    <i class="fas fa-inbox"></i>
                </div>
                <div class="stat-info">
                    <h3 id="stat-incoming-count">0</h3>
                    <p>Incoming Requests</p>
                </div>
            </div>
            <div class="stat-card" data-stat-type="my-posts">
                <div class="stat-icon bg-success"><i class="fas fa-paw"></i></div>
                <div class="stat-info">
                    <h3 id="stat-posts-count">0</h3>
                    <p>My Posts</p>
                </div>
            </div>
        </div>

        <div class="dashboard-tabs">
            <button class="tab-btn active" data-tab="saved">
                <i class="fas fa-heart"></i> Saved
            </button>
            <button class="tab-btn" data-tab="my-requests">
                <i class="fas fa-paper-plane"></i> My Requests Sent
            </button>
            <button class="tab-btn" data-tab="my-posts">
                <i class="fas fa-paw"></i> My Posts & Requests
            </button>
        </div>

        <div id="saved" class="tab-content active">
            <div class="sub-tabs">
                <button class="sub-tab-btn active" data-subtab="adoption">Adoption Posts</button>
                <button class="sub-tab-btn" data-subtab="products">Products Posts</button>
                <button class="sub-tab-btn" data-subtab="sitters">Sitters Posts</button>
                <button class="sub-tab-btn" data-subtab="lost-pets">Lost Pets Posts</button>
            </div>
            <div class="sub-tab-contents">
                <div id="saved-adoption" class="sub-tab-content active">
                    <div class="cards-grid" id="saved-adoption-grid"></div>
                </div>
                <div id="saved-products" class="sub-tab-content">
                    <div class="cards-grid" id="saved-products-grid"></div>
                </div>
                <div id="saved-sitters" class="sub-tab-content">
                    <div class="cards-grid" id="saved-sitters-grid"></div>
                </div>
                <div id="saved-lost-pets" class="sub-tab-content">
                    <div class="cards-grid" id="saved-lost-pets-grid"></div>
                </div>
            </div>
        </div>

        <div id="my-requests" class="tab-content">
            <div class="sub-tabs">
                <button class="sub-tab-btn active" data-subtab="adoption">Adoption Requests</button>
                <button class="sub-tab-btn" data-subtab="products">Products Requests</button>
                <button class="sub-tab-btn" data-subtab="sitters">Sitters Requests</button>
                <button class="sub-tab-btn" data-subtab="lost-pets">Lost Pets Requests</button>
            </div>
            <div class="sub-tab-contents">
                <div id="requests-adoption" class="sub-tab-content active">
                    <div class="request-list-container" id="requests-adoption-container"></div>
                </div>
                <div id="requests-products" class="sub-tab-content">
                    <div class="request-list-container" id="requests-products-container"></div>
                </div>
                <div id="requests-sitters" class="sub-tab-content">
                    <div class="request-list-container" id="requests-sitters-container"></div>
                </div>
                <div id="requests-lost-pets" class="sub-tab-content">
                    <div class="request-list-container" id="requests-lost-pets-container"></div>
                </div>
            </div>
        </div>

        <div id="my-posts" class="tab-content">
            <div class="sub-tabs">
                <button class="sub-tab-btn active" data-subtab="adoption">My Adoption Posts</button>
                <button class="sub-tab-btn" data-subtab="products">My Products Posts</button>
                <button class="sub-tab-btn" data-subtab="sitters">My Sitters Posts</button>
                <button class="sub-tab-btn" data-subtab="lost-pets">My Lost Pets Posts</button>
            </div>
            <div class="sub-tab-contents">
                <div id="posts-adoption" class="sub-tab-content active">
                    <div class="post-management-view" data-view-state="grid" id="posts-adoption-view">
                        <div class="cards-grid grid-view active" id="posts-adoption-grid"></div>
                        <div class="post-details-view" id="posts-adoption-details">
                            <button class="back-to-grid-btn"><i class="fas fa-arrow-left"></i> Back to All
                                Posts</button>
                            <div class="single-post-card-wrapper"></div>
                            <div class="dlt-btn-container">
                                <button class="btn-dlt"><i class="fas fa-trash"></i> Delete Post</button>
                            </div>
                            <h2 class="incoming-requests-header">Incoming Requests (<span
                                    id="incoming-count-adoption">0</span>)</h2>
                            <div class="request-list-container incoming-requests-list"
                                id="incoming-adoption-container"></div>
                        </div>
                    </div>
                </div>
                <div id="posts-products" class="sub-tab-content">
                    <div class="post-management-view" data-view-state="grid" id="posts-products-view">
                        <div class="cards-grid grid-view active" id="posts-products-grid"></div>
                        <div class="post-details-view" id="posts-products-details">
                            <button class="back-to-grid-btn"><i class="fas fa-arrow-left"></i> Back to All
                                Posts</button>
                            <div class="single-post-card-wrapper"></div>
                            <div class="dlt-btn-container">
                                <button class="btn-dlt"><i class="fas fa-trash"></i> Delete Post</button>
                            </div>
                            <h2 class="incoming-requests-header">Incoming Requests (<span
                                    id="incoming-count-products">0</span>)</h2>
                            <div class="request-list-container incoming-requests-list"
                                id="incoming-products-container"></div>
                        </div>
                    </div>
                </div>
                <div id="posts-sitters" class="sub-tab-content">
                    <div class="post-management-view" data-view-state="grid" id="posts-sitters-view">
                        <div class="cards-grid grid-view active" id="posts-sitters-grid"></div>
                        <div class="post-details-view" id="posts-sitters-details">
                            <button class="back-to-grid-btn"><i class="fas fa-arrow-left"></i> Back to All
                                Posts</button>
                            <div class="single-post-card-wrapper"></div>
                            <div class="dlt-btn-container">
                                <button class="btn-dlt"><i class="fas fa-trash"></i> Delete Post</button>
                            </div>
                            <h2 class="incoming-requests-header">Incoming Requests (<span
                                    id="incoming-count-sitters">0</span>)</h2>
                            <div class="request-list-container incoming-requests-list"
                                id="incoming-sitters-container"></div>
                        </div>
                    </div>
                </div>
                <div id="posts-lost-pets" class="sub-tab-content">
                    <div class="post-management-view" data-view-state="grid" id="posts-lost-pets-view">
                        <div class="cards-grid grid-view active" id="posts-lost-pets-grid"></div>
                        <div class="post-details-view" id="posts-lost-pets-details">
                            <button class="back-to-grid-btn"><i class="fas fa-arrow-left"></i> Back to All
                                Posts</button>
                            <div class="single-post-card-wrapper"></div>
                            <div class="dlt-btn-container">
                                <button class="btn-dlt"><i class="fas fa-trash"></i> Delete Post</button>
                            </div>
                            <h2 class="incoming-requests-header">Incoming Requests (<span
                                    id="incoming-count-lost-pets">0</span>)</h2>
                            <div class="request-list-container incoming-requests-list"
                                id="incoming-lost-pets-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="notification-container" class="notification-container"></div>
    <script>
        window.CURRENT_USER_ID = {{ auth()->id() }};
    </script>

    <script type="module" src="{{ asset('/js/other-scripts/user-dashboard.js') }}"></script>
</body>

</html>
