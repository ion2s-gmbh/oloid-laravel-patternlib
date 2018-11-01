let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js');

mix.sass('resources/sass/app.scss', 'public/css');

/** @todo find a better solution */
mix.copyDirectory('public/js', '../laravel/application/public/vendor/ion2s/laratomics-workshop/js') // for development only
  .copyDirectory('public/css', '../laravel/application/public/vendor/ion2s/laratomics-workshop/css'); // for development only


/*
|-----------------------------------------------------------------------
| BrowserSync
|-----------------------------------------------------------------------
|
| BrowserSync refreshes the Browser if file changes (js, sass, php) are | detected.
| Proxy specifies the location where the app is located.
|
| Virtualbox/Vagrant environment: proxy: 'http(s)://xxx.xxx.xxx.xxx' or a domain.
| Localhost environment: proxy: 'http(s)://localhost' or 'http(s)://localhost:8000'
*/
mix.browserSync({
  proxy: 'http://localhost:8000',
  open: true,
  watchOptions: {
    usePolling: false
  }
});