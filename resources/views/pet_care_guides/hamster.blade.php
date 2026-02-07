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
    <title>Hamster Care Guide</title>
</head>
<body>

<div class="guide">
  <h1>🐹 Hamster Care Guide</h1>

  <h2>Habitat</h2>
  <ul class="list">
    <li class="element">Choose a spacious cage or tank with good ventilation and secure lid.</li>
    <li class="element">Provide tunnels, hiding houses, and nesting material for security.</li>
    <li class="element">Use safe bedding (paper-based or aspen); avoid cedar/pine.</li>
  </ul>

  <h2>Feeding</h2>
  <ul class="list">
    <li class="element">Offer a quality hamster mix or pellets daily plus small fresh veggies.</li>
    <li class="element">Give treats sparingly (seeds, fruit pieces occasionally).</li>
    <li class="element">Always provide fresh water via a sipper bottle or shallow dish.</li>
  </ul>

  <h2>Exercise & Enrichment</h2>
  <ul class="list">
    <li class="element">Include a solid-surface running wheel (no wire rungs) sized for the species.</li>
    <li class="element">Add chew toys, tunnels, and rotate toys to prevent boredom.</li>
    <li class="element">Allow supervised out-of-cage play in a secure playpen. Hamsters are nocturnal—most active at night.</li>
  </ul>

  <h2>Cleaning & Grooming</h2>
  <ul class="list">
    <li class="element">Spot-clean daily and fully change bedding weekly (or sooner if needed).</li>
    <li class="element">Most hamsters self-groom; provide a sand bath for dwarf species if desired.</li>
  </ul>

  <h2>Handling & Temperament</h2>
  <ul class="list">
    <li class="element">Handle gently and patiently; let them sniff your hand before lifting.</li>
    <li class="element">Avoid waking them suddenly—grumpy when startled.</li>
  </ul>

  <h2>Health</h2>
  <ul class="list">
    <li>Watch for changes in eating, breathing, fur condition, or lethargy; see a vet if concerned.</li>
    <li>Keep habitat away from drafts, extreme heat, and loud noise.</li>
  </ul>

  <footer>Simple routine + safe habitat = a healthy, happy hamster.</footer>
</div>

    @include('partials.header')

</body>
</html>
