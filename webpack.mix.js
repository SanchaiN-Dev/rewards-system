const mix = require('laravel-mix'); // Import Laravel Mix
const { VueLoaderPlugin } = require('vue-loader'); // Import VueLoaderPlugin

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining Webpack build steps
 | for your Laravel applications. We are compiling the JS and CSS
 | for the application as well as other assets.
 |
 */

mix.js('resources/js/app.js', 'public/js') // Compile Vue app.js
   .vue() // Enable Vue support
   .postCss('resources/css/app.css', 'public/css') // Compile CSS file
   .minify('public/assets/js/soft-ui-dashboard.js'); // Minify dashboard JS

mix.sass('public/assets/scss/soft-ui-dashboard.scss', 'public/assets/css'); // Compile SCSS file to CSS

// Add Webpack configuration for Vue Loader
mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.vue$/, // Match .vue files
                loader: 'vue-loader', // Use vue-loader to process Vue files
            },
        ],
    },
    plugins: [
        new VueLoaderPlugin(), // Add VueLoaderPlugin for Vue file processing
    ],
});
