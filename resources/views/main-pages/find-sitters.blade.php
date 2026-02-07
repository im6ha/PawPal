<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('media/images/logo-brand.png') }}" />

    <link rel="stylesheet" href="{{ asset('css/components/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components/footer.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components/filters.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components/cards.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/main-pages/find-sitters.css') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
      rel="stylesheet"
    />

    <title>Pet Sitters - PetCare</title>
  </head>
  <body>
    <main>
      <div class="page-header">
        <h1>Find a Pet Sitter</h1>
        <p>
          Connect with trusted pet sitters in your area to care for your furry friends while you're away
        </p>
      </div>
      @if(session('error'))
      <div class="alert" >
          {{ session('error') }}
      </div>
      @endif

      <div class="filters-section">
        <div class="filters-header">
          <h2>Filter Sitters</h2>
          <button class="create-post" onclick="window.location.href='{{ auth()->check() ? route('sitter-form') : route('login-page') }}'">
              <span>Apply</span>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="plus">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
              </svg>
          </button>

        </div>
        <div class="filters">
          <div class="filter" id="filter-pet"></div>
          <div class="filter" id="filter-price"></div>
          <div class="filter" id="filter-location"></div>
        </div>
      </div>

      <div class="sitters-grid" id="sitters-grid"></div>
    </main>

    <footer class="footer">
      @include('partials.footer')
    </footer>

    @include('partials.header')
    <script src="{{ asset('js/main-pages/find-sitters.js') }}" type="module"></script>
  </body>
</html>
