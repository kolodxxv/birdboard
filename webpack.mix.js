const mix = require('laravel-mix');

// PostCSS configuration
mix.postCss('resources/css/app.css', 'public/css', 
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
);

// SASS configuration
mix.sass('resources/sass/main.scss', 'public/css');
