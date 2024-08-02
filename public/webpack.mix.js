const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
       require('tailwindcss'),
   ])
   .copy('node_modules/flowbite/dist/flowbite.css', 'public/css/flowbite.css')
   .version();
