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
    <title>Rabbit Care Guide</title>
</head>
<body>

<div class="guide">
  <h1>🐰 Rabbit Care Guide</h1>

  <h2>Housing</h2>
  <ul class="list">
    <li class="element">Provide a roomy, secure enclosure or pen with space to hop (minimum several times the rabbit's length).</li>
    <li class="element">Soft bedding (paper-based or hay); avoid cedar/pine shavings.</li>
    <li class="element">Allow daily supervised free-roam time in a rabbit-proofed area.</li>
  </ul>

  <h2>Feeding</h2>
  <ul class="list">
    <li class="element">Unlimited fresh hay (timothy or meadow) — the foundation of the diet.</li>
    <li class="element">High-quality pellets in measured amounts; adjust by age and weight.</li>
    <li class="element">Fresh leafy greens daily; introduce new veggies slowly. Fresh water always available.</li>
  </ul>

  <h2>Grooming & Care</h2>
  <ul class="list">
    <li class="element">Brush regularly (more often during shedding) to prevent hairballs.</li>
    <li class="element">Trim nails every few weeks; check teeth—overgrowth needs vet care.</li>
    <li class="element">Clean living area and litter box frequently.</li>
  </ul>

  <h2>Health</h2>
  <ul class="list">
    <li class="element">Find a rabbit-savvy vet; annual checkups recommended.</li>
    <li class="element">Spay/neuter to prevent health/behavior issues and reduce aggression.</li>
    <li class="element">Watch for appetite loss, drooling, diarrhea, or lethargy — act quickly.</li>
  </ul>

  <h2>Enrichment & Behavior</h2>
  <ul class="list">
    <li class="element">Provide chew toys, tunnels, and hiding spots for mental stimulation.</li>
    <li class="element">Rabbits are social — bond with gentle, patient handling and routine.</li>
    <li class="element">Use positive reinforcement; never pick up by ears.</li>
  </ul>

  <h2>Litter Training</h2>
  <ul class="list">
    <li class="element">Most rabbits can be litter-trained—place a box with hay in a corner they already use.</li>
    <li class="element">Clean accidents with enzyme cleaner and reward use of the box.</li>
  </ul>

  <footer>Safe housing, lots of hay, gentle handling, and regular vet care keep rabbits healthy and happy.</footer>
</div>


    @include('partials.header')
</body>
</html>
