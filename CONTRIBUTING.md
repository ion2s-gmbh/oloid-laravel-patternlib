# Contributing

First things first: Thanks for considering to contributing to oloid-laravel-patternlib.

Feel free to fork our repository and send a PR to the master branch.

# Setup the development environment

1. Create a standard Laravel application.
2. Link the package oloid-laravel-patternlib in composer.json

## Recommended folder structure
* oloid
    * packages
        * oloid-laravel-patternlib
    * laravel

This structure will be created in the following steps.

### Oloid-laravel-patternlib
```bash
mkdir -p oloid/packages
git clone git@github.com:ion2s-gmbh/oloid-laravel-patternlib.git
```

### Laravel
Setup a plain Laravel 5.7+ application following the instructions in the [official documentation](https://laravel.com/docs/5.7/installation#installing-laravel)
```bash
composer create-project --prefer-dist laravel/laravel laravel
```

### Link the package
Finally you have to link the oloid-laravel-patternlib package in the Laravel application and you're ready to go.
In Laravel's composer.json add:
```
"repositories": [
    {
      "type":"path",
      "url":"/path/to/oloid-laravel-patternlib"
    }
  ],
```
And in the require-dev section add:
```
"ion2s/oloid-laravel-patternlib": "*",
```

Then run:
```bash
composer update
```
You should see ion2s/oloid-laravel-patternlib in the list of discovered packages.

You can execute the tests with:
```bash
composer test
```

### Preparing the frontend
Finally you have to build the frontend:
```bash
cd /path/to/oloid-laravel-patternlib
npm install
npm run dev
```

### BrowserSync
To have a better frontend development experience you can use BrowserSync.
The configuration can be found in `ẁebpack.mix.js`.  
You can have webpack to watch and sync your frontend changes by running:
```bash
npm run watch
```