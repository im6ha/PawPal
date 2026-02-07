<header>
    <div class="upper-bar">
        <ul>
            <li>Ar</li>
            <li>Fr</li>
            <li>En</li>
        </ul>
        <div class="login-con">
            @guest
                <a href="{{ route('login-page') }}" class="login">SIGN UP | LOGIN</a>
            @else
                <div class="account-con">
                    <button class="account-icon" aria-label="Account">

                        @if (auth()->user()->profile_image)
                            <img src="{{ asset(auth()->user()->profile_image) }}" alt="Profile Picture" class="profile-pic">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 16 16">
                                <path fill="#000000"
                                    d="M16 7.992C16 3.58 12.416 0 8 0S0 3.58 0 7.992c0 2.43 1.104 4.62 2.832 6.09c.016.016.032.016.032.032c.144.112.288.224.448.336c.08.048.144.111.224.175A7.98 7.98 0 0 0 8.016 16a7.98 7.98 0 0 0 4.48-1.375c.08-.048.144-.111.224-.16c.144-.111.304-.223.448-.335c.016-.016.032-.016.032-.032c1.696-1.487 2.8-3.676 2.8-6.106z" />
                            </svg>
                        @endif
                    </button>


                    <div class="account-dropdown">
                        @if (auth()->user()->is_admin === 1)
                            <a href="{{ route('admin-dashboard') }}" class="account-link">Dashboard</a>
                        @endif <a href="{{ route('user-dashboard') }}" class="account-link">My
                            Dashboard</a>
                        <a href="{{ route('profile') }}" class="account-link">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="account-link logout"
                                style="background:none; border:none; cursor:pointer;">Logout</button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>

    <nav>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="size-6 stack">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
        </svg>

        <div class="logo-con">
            <img class="logo" src="{{ asset('media/images/logo.png') }}" alt="PawPal logo">
        </div>

        <ul>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ route('adopt') }}">Adopt</a></li>
            <li><a href="{{ route('market') }}">Market</a></li>
            <li><a href="{{ route('find-sitters') }}">Find Sitters</a></li>
            <li><a href="{{ route('lost-pets') }}">Lost Pets</a></li>
            <li><a href="{{ route('pet-care-guide') }}">Pet Care Guide</a></li>
        </ul>
    </nav>
</header>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const accountBtn = document.querySelector('.account-icon');
        const dropdown = document.querySelector('.account-dropdown');

        if (accountBtn && dropdown) {
            accountBtn.addEventListener('click', (evt) => {
                evt.stopPropagation();
                dropdown.classList.toggle('active');
            });

            document.addEventListener('click', (e) => {
                if (!dropdown.contains(e.target) && !accountBtn.contains(e.target)) {
                    dropdown.classList.remove('active');
                }
            });
        }

        const logo = document.querySelector(".logo-con");
        if (logo) {
            logo.addEventListener("click", () => {
                location.href = "{{ url('/') }}";
            });
        }
    });

    const stackButton = document.querySelector('.stack');
const navMenu = document.querySelector('nav ul');

if (stackButton && navMenu) {
    stackButton.addEventListener('click', () => {
        navMenu.classList.toggle('show');
    });
}
</script>
