<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="{{ asset('css/components/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components/footer.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/main-pages/pet-care.css') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
      rel="stylesheet"
    />

    <link rel="icon" type="image/png" href="{{ asset('media/images/logo-brand.png') }}" />

    <title>Pet Care Guide</title>
  </head>
  <body>
    <main id="pet-care-home">
      <h1>Pet Care Guide</h1>

      <div class="grid">
        <a href="{{ route('cat') }}" class="animal cat">
          <p>Cat</p>
        </a>
        <a href="{{ route('dog') }}" class="animal dog">
          <p>Dog</p>
        </a>
        <a href="{{ route('hamster') }}" class="animal hamster">
          <p>Hamster</p>
        </a>
        <a href="{{ route('bird') }}" class="animal bird">
          <p>Bird</p>
        </a>
        <a href="{{ route('rabbit') }}" class="animal rabbit">
          <p>Rabbit</p>
        </a>
        <a href="{{ route('fish') }}" class="animal fish">
          <p>Fish</p>
        </a>
      </div>
    </main>

    <footer class="footer">    @include('partials.footer')</footer>

    @include('partials.header')

  </body>
</html>
