<footer>
    <div class="container">
        <div class="footer-content">
            <div class="footer-brand">
                <img
                    src="{{ asset('media/images/logo-brand.png') }}"
                    alt="PawPal"
                    class="footer-logo"
                />
                <p>
                    Connecting pets with loving homes and caring owners since 2024.
                </p>
            </div>
            <div class="footer-links">
                <h4>Services</h4>
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('adopt') }}">Adopt</a>
                <a href="{{ route('market') }}">Marketplace</a>
                <a href="{{ route('find-sitters') }}">Pet Sitting</a>
                <a href="{{ route('lost-pets') }}">Lost & Found</a>
                <a href="{{ route('pet-care-guide') }}">Pet Care Guide</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 PawPal. All rights reserved.</p>
        </div>
    </div>
</footer>
