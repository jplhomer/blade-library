const mix = require('laravel-mix');

mix.setPublicPath('public')
    .postCss('resources/css/main.css', 'public/css', [
        require('tailwindcss'),
    ])
