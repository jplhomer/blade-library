<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blade Library</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@600&display=swap" rel="stylesheet">
    @livewireStyles
    <link href="{{ asset(mix('css/main.css', 'vendor/blade-library')) }}" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.3.5/dist/alpine.min.js" defer></script>
</head>
<body>
    <livewire:blade-library />

    @livewireScripts
</body>
</html>
