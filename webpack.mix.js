let mix = require('laravel-mix');
mix.js('resources/assets/app/app.js', 'public/app');
mix.copy('resources/assets/theme', 'public/theme');
