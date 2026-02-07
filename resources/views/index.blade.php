<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/components/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main-pages/home.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('media/images/logo-brand.png') }}">
    <title>PawPal</title>
</head>

<body>
    @include('partials.header')

    <main>
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <h1 class="hero-title">
                    Adopting a pet won't change the world
                    <span class="hero-highlight">but it changes <em>theirs</em> forever</span>
                </h1>

                @guest
                    <p class="hero-subtitle">Join PawPal and give your pet the loving care they deserve</p>
                    <div class="hero-actions">
                        <a href="{{ route('login-page') }}" class="btn btn-primary">Get Started</a>
                        <a href="{{ route('adopt') }}" class="btn btn-secondary">Meet Our Pets</a>
                    </div>
                @endguest

                @auth
                    <p class="hero-subtitle">Welcome back, {{ auth()->user()->name }}! Ready to help more pets?</p>
                @endauth
            </div>
        </section>

        <!-- Services Section -->
        <section class="services-section">
            <div class="container">
                <h2 class="section-title">How PawPal Helps You Care</h2>
                <div class="services-grid">
                    <div class="service-card">
                        <div class="service-icon">🐾</div>
                        <h3>Adopt a Friend</h3>
                        <p>Give a homeless animal a new life filled with love and care. Find your perfect companion
                            today.</p>
                        <a href="{{ route('adopt') }}" class="service-link">Find Your Match →</a>
                    </div>
                    <div class="service-card">
                        <div class="service-icon">🛍️</div>
                        <h3>Pet Marketplace</h3>
                        <p>Discover high-quality accessories, toys, and essentials to keep your pet happy and healthy.
                        </p>
                        <a href="{{ route('market') }}" class="service-link">Shop Now →</a>
                    </div>
                    <div class="service-card">
                        <div class="service-icon">🏠</div>
                        <h3>Trusted Sitters</h3>
                        <p>Find caring pet sitters who'll treat your pets like family when you need a break.</p>
                        <a href="{{ route('find-sitters') }}" class="service-link">Find Care →</a>
                    </div>
                    <div class="service-card">
                        <div class="service-icon">🔍</div>
                        <h3>Lost & Found</h3>
                        <p>Our community helps reunite lost pets with their families quickly and safely.</p>
                        <a href="{{ route('lost-pets') }}" class="service-link">Get Help →</a>
                    </div>
                    <div class="service-card">
                        <div class="service-icon">📚</div>
                        <h3>Pet Care Guide</h3>
                        <p>Learn how to properly care for your pets with our comprehensive guides and expert tips for
                            all types of animals.</p>
                        <a href="{{ route('pet-care-guide') }}" class="service-link">Learn More →</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="stats-section">
            <div class="container">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Pets Adopted</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">200+</div>
                        <div class="stat-label">Trusted Sitters</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">1k+</div>
                        <div class="stat-label">Happy Families</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Pets Reunited</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Facts Section -->
        <section class="pet-facts-section">
            <div class="container">
                <h2 class="section-title">Did You Know? Pet Facts</h2>
                <div class="facts-grid">
                    <div class="fact-card">
                        <div class="fact-content">
                            <h3>Better Heart Health</h3>
                            <p>Pet owners have 30% lower risk of heart disease</p>
                        </div>
                    </div>
                    <div class="fact-card">
                        <div class="fact-content">
                            <h3>Stress Reduction</h3>
                            <p>Playing with pets reduces stress and lowers blood pressure</p>
                        </div>
                    </div>
                    <div class="fact-card">
                        <div class="fact-content">
                            <h3>Active Lifestyle</h3>
                            <p>Dog owners walk 30 minutes more per day on average</p>
                        </div>
                    </div>
                    <div class="fact-card">
                        <div class="fact-content">
                            <h3>Combat Loneliness</h3>
                            <p>Pet companionship can reduce feelings of loneliness by 60%</p>
                        </div>
                    </div>
                    <div class="fact-card">
                        <div class="fact-content">
                            <h3>Mental Well-being</h3>
                            <p>Pet owners report 25% fewer doctor visits for minor health issues</p>
                        </div>
                    </div>
                    <div class="fact-card">
                        <div class="fact-content">
                            <h3>Social Connections</h3>
                            <p>Pet owners are 60% more likely to meet new people in their community</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        @guest
            <section class="cta-section">
                <div class="container">
                    <div class="cta-content">
                        <h2>Ready to Make a Difference?</h2>
                        <p>Join thousands of pet lovers who trust PawPal for their pet care needs.</p>
                        <div class="cta-actions">
                            <a href="{{ route('login-page') }}" class="btn btn-primary">Join Now</a>
                            <a href="{{ route('adopt') }}" class="btn btn-outline">Adopt a Pet</a>
                        </div>
                    </div>
                </div>
            </section>
        @endguest

    </main>

    <footer class="footer">
        @include('partials.footer')
    </footer>

</body>

</html>
