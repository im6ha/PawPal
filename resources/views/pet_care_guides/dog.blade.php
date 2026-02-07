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
    <title>Dog Care Guide</title>
</head>
<body>

<div class="guide">
  <h1>🐶 Dog Care Guide</h1>

  <h2>Home Setup</h2>
  <ul class="list">
    <li class="element">Prepare a soft bed and quiet resting area.</li>
    <li class="element">Provide clean bowls for food and water.</li>
    <li class="element">Keep toys and chew items for play and dental health.</li>
  </ul>

  <h2>Feeding</h2>
  <ul class="list">
    <li class="element">Feed 1-2 meals daily with balanced dog food.</li>
    <li class="element">Always keep fresh water available.</li>
    <li class="element">Avoid chocolate, onions, grapes, or cooked bones.</li>
  </ul>

  <h2>Grooming</h2>
  <ul class="list">
    <li class="element">Brush regularly based on coat type.</li>
    <li class="element">Bathe every 4–6 weeks or as needed.</li>
    <li class="element">Trim nails and clean ears regularly.</li>
  </ul>

  <h2>Health</h2>
  <ul class="list">
    <li class="element">Visit the vet yearly for vaccines and checkups.</li>
    <li class="element">Use flea, tick, and worm prevention.</li>
    <li class="element">Spay/neuter to prevent health and behavior problems.</li>
  </ul>

  <h2>Exercise & Training</h2>
  <ul class="list">
    <li class="element">Walk your dog daily to stay fit and happy.</li>
    <li class="element">Train using positive reinforcement (treats, praise).</li>
    <li class="element">Provide mental stimulation with toys or short games.</li>
  </ul>

  <footer>Keep your dog active, loved, and well-fed — a healthy dog is a happy companion!</footer>
</div>

    @include('partials.header')

</body>
</html>
