<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/components/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components/footer.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components/filters.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components/cards.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/main-pages/lost-pets.css') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
      rel="stylesheet"
    />

    <link rel="icon" type="image/png" href="{{ asset('media/images/logo-brand.png') }}" />

    <title>Lost Pets | PawPal — Find Your Pet Fast</title>
  </head>
  <body>
    <main>
      <section class="urgent-banner" role="alert" aria-live="polite">
        <div class="container">
          <div class="banner-content">
            <svg xmlns="http://www.w3.org/2000/svg" class="banner-icon" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
            </svg>
            <div>
              <h2>Lost your pet? Stay calm — help is here.</h2>
              <p>✅ 93% of lost pets are found within 24 hours. Start by reporting below.</p>
            </div>
          </div>
        </div>
      </section>

      <section class="report-section">
        <div class="container">
          <div class="report-card">
            <h3>🚨 Report a Missing Pet</h3>
            <p>It takes 60 seconds — and alerts our entire community.</p>
            <button id="reportBtn" class="btn btn--urgent" onclick="window.location.href='{{ route('report-lost') }}'">
              <svg xmlns="http://www.w3.org/2000/svg" class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
              </svg>
              Report Now
            </button>
            <p class="note">We’ll never share your number publicly. Only verified finders can contact you.</p>
          </div>
        </div>
      </section>

      <div class="pseudo-div"></div>

      <h2>Recent Reports:</h2>

      <section class="filters">
        <div class="filter" id="filter-pet"></div>
        <div class="filter" id="filter-location"></div>
      </section>

      <section class="reports-section">
        <div class="reports-grid" id="reports-grid"></div>
      </section>

      <section class="tips-section">
        <div class="container">
          <h2>🛡️ Stay Safe — Avoid Scams</h2>
          <ul class="tips-list">
            <li>✅ <strong>Never pay upfront</strong> — legitimate finders don’t ask for money before return.</li>
            <li>✅ <strong>Verify identity</strong> — ask for photo with pet + ID (blur personal info).</li>
            <li>✅ <strong>Meet in public</strong> — police stations or vet clinics are safest.</li>
            <li>✅ <strong>Report scams</strong> — contact us immediately at support@pawpal.dz</li>
          </ul>
        </div>
      </section>
    </main>

    <footer class="footer"> 
      @include('partials.footer')
    </footer>

    @include('partials.header')
    <script src="{{ asset('js/main-pages/lost-pets.js') }}" type="module"></script>
  </body>
</html>
