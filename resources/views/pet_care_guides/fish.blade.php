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
    <title>Fish Care Guide</title>
</head>
<body>

<div class="guide">
  <h1>🐟 Fish Care Guide</h1>

  <h2>Tank Setup</h2>
  <ul class="list">
    <li class="element">Choose the right tank size for the species (bigger is easier to keep stable).</li>
    <li class="element">Use a proper filter, heater (if tropical), and a secure lid.</li>
    <li class="element">Provide substrate, hiding spots, and plants suited to the fish.</li>
  </ul>

  <h2>Water & Filtration</h2>
  <ul class="list">
    <li class="element">Condition tap water to remove chlorine and chloramines before adding.</li>
    <li class="element">Maintain stable temperature and monitor pH, ammonia, nitrite, and nitrate.</li>
    <li class="element">Run the filter continuously and cycle new tanks before adding fish.</li>
  </ul>

  <h2>Feeding</h2>
  <ul class="list">
    <li class="element">Feed species-appropriate food once or twice daily; only what they eat in a few minutes.</li>
    <li class="element">Avoid overfeeding—uneaten food pollutes the water.</li>
  </ul>

  <h2>Maintenance</h2>
  <ul class="list">
    <li class="element">Do regular partial water changes (10–30% weekly or biweekly depending on load).</li>
    <li class="element">Clean filter media per manufacturer instructions (don’t use tap water on beneficial bacteria).</li>
  </ul>

  <h2>Health</h2>
  <ul class="list">
    <li class="element">Quarantine new fish for 2–4 weeks to prevent disease spread.</li>
    <li class="element">Watch for signs like gasping, spots, frayed fins, or loss of appetite; treat promptly.</li>
  </ul>

  <h2>Enrichment</h2>
  <ul class="list">
    <li class="element">Add plants, caves, and variation in décor to reduce stress and allow natural behavior.</li>
    <li class="element">Keep compatible tankmates and avoid overcrowding.</li>
  </ul>

  <footer>Stable water, proper feeding, and clean habitat are the keys to healthy fish.</footer>
</div>

    @include('partials.header')

</body>
</html>
