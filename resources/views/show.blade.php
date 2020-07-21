<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blade Library</title>
    @livewireStyles

    @include('library::partials.head')
</head>
<body>

<div style="padding: .5em">
    @include($view)
</div>

@livewireScripts
</body>
</html>
