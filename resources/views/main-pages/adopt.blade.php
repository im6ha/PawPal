<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="{{ asset('css/components/header.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/components/footer.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/components/filters.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/components/cards.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/main-pages/adopt.css') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
  <title>Adopt — Your New Best Friend</title>
</head>
<body>
  <main>
    <section class="filters">
      <div class="filter" id="filter-pet"></div>
      <div class="filter" id="filter-location"></div>
      <div class="filter" id="filter-gender"></div>

      <button class="create-post" onclick="window.location.href='{{ route('adoption-form') }}'">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="plus">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>      </button>
    </section>

    <section class="adopt-intro">
      <h2>Find Your Perfect Companion</h2>
      <p>Explore pets ready for adoption near you, give them a new home — and gain a loyal friend.</p>
    </section>

    <section class="cards"></section>
  </main>

  @include('partials.footer')
  @include('partials.header')

  <script type="module">
    import { createPetCard } from "{{ asset('js/components/cards.js') }}";

    const pets = @json($pets);
    const cardsContainer = document.querySelector(".cards");

    pets.forEach(pet => {
      cardsContainer.appendChild(
        createPetCard(
          `{{ asset('') }}${pet.picture}`,
          pet.type,
          pet.description,
          pet.wilaya,
          pet.gender
        )
      );
    });
  </script>

  <script type="module" src="{{ asset('js/main-pages/adopt.js') }}"></script>
</body>
</html>
