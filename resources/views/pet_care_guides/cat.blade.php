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
        <h1>🐱 Cat Care Guide</h1>

        <h2>Home Setup</h2>
        <ul class="list">
          <li class="element">Provide a cozy bed and clean litter box.</li>
          <li class="element">Keep food, water, and toys available.</li>
          <li class="element">Add a scratching post to protect furniture.</li>
        </ul>

        <h2>Feeding</h2>
        <ul class="list">
          <li class="element">Feed 2-3 meals daily with quality cat food.</li>
          <li class="element">Always keep fresh water nearby.</li>
          <li class="element">Avoid human food like onions or chocolate.</li>
        </ul>

        <h2>Grooming</h2>
        <ul class="list">
          <li class="element">Brush weekly; bathe rarely.</li>
          <li class="element">Trim nails monthly and clean the litter box often.</li>
        </ul>

        <h2>Health</h2>
        <ul class="list">
          <li class="element">Visit the vet yearly for vaccines and checkups.</li>
          <li class="element">Spay/neuter and use flea prevention.</li>
        </ul>

        <h2>Love & Play</h2>
        <ul class="list">
          <li class="element">Play daily and show gentle affection.</li>
          <li class="element">Give space when they want alone time.</li>
        </ul>

        <footer>Keep your cat safe, clean, and loved — a happy cat lives long!</footer>
    </div>

    @include('partials.header')
</body>
</html>
