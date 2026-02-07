<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="icon" type="image/png" href="{{ asset('media/images/logo-brand.png') }}" />

    <link rel="stylesheet" href="{{ asset('css/components/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components/footer.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components/filters.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components/cards.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/main-pages/market.css') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
      rel="stylesheet"
    />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Market</title>
  </head>
  <body>
    <main>
      <section class="filter-container1">
        <div class="filter" id="filter-pet"></div>
        <div class="filter" id="filter-category"></div>
      </section>

      <section class="products">
        <div class="products-header">
          <h2>Available Products:</h2>
          <button class="create-post" id="add-product">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="plus">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
          </button>
        </div>
        <div class="products-list" id="products-list"></div>
      </section>

      <section class="filter-container2">
        <div class="filter" id="filter-price"></div>
        <div class="filter" id="filter-location"></div>
      </section>
    </main>

    <footer class="footer">    @include('partials.footer')
    </footer>

    @include('partials.header')
    <script src="{{ asset('js/main-pages/market.js') }}" type="module"></script>
  </body>
</html>
