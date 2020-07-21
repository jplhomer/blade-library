<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blade Library</title>
    @livewireStyles

    {{-- TODO: Allow user to pull their own layout, or insert scripts/styles --}}
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

<div style="padding: .5em">
    @include($view)
</div>

@livewireScripts
</body>
</html>
