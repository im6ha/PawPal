<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/components/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main-pages/pet-care.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('media/images/logo-brand.png') }}">
    <title>Cat Care Guide</title>
</head>
<body>
<div class="guide">
  <h1>🐦 Bird Care Guide</h1>

  <h2>Cage & Environment</h2>
  <ul class="list">
    <li class="element">Choose a cage big enough to stretch wings and climb; horizontal bars help climbing.</li>
    <li class="element">Place cage away from drafts, direct sun, and kitchen fumes.</li>
    <li class="element">Provide perches of varying thicknesses and safe toys for chewing.</li>
  </ul>

  <h2>Feeding</h2>
  <ul class="list">
    <li class="element">Offer a balanced diet: species-appropriate pellets + fresh fruits/veggies.</li>
    <li class="element">Remove uneaten fresh food daily and keep clean water available.</li>
    <li class="element">Avoid avocado, chocolate, caffeine, alcohol, and salty/fatty foods.</li>
  </ul>

  <h2>Hygiene</h2>
  <ul class="list">
    <li class="element">Clean cage tray and bowls daily; deep-clean cage weekly.</li>
    <li class="element">Provide bathing opportunities (shallow dish or gentle misting).</li>
  </ul>

  <h2>Health & Vet Care</h2>
  <ul class="list">
    <li class="element">Find an avian vet; annual checkups are recommended.</li>
    <li class="element">Watch for changes in dropping.</li>
  </ul>
</div>

    @include('partials.header')
</body>
</html>
