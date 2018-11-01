# Contributing

First things first: Thanks for considering to contributing to laratomics-workshop.

Feel free to fork our repository and send a PR to the master branch.

# Setup the development environment

1. Create a standard Laravel application.
2. Link the package laratomics-workshop in composer.json

## Recommended folder structure
* laratomics
    * packages
        * laratomics-workshop
    * laravel

This structure will be created in the following steps.

### Laratomics-workshop
```bash
mkdir -p laratomics/packages
git clone git@github.com:poolingpeople/laratomics-workshop.git
```

### Laravel
Setup a plain Laravel 5.7+ application following the instructions in the [official documentation](https://laravel.com/docs/5.7/installation#installing-laravel)
```bash
composer create-project --prefer-dist laravel/laravel laravel
```

### Link the package
Finally you have to link the laravel-workshop package in the Laravel application and you're ready to go.
In Laravel's composer.json add:
```
"repositories": [
    {
      "type":"path",
      "url":"/path/to/laratomics-workshop"
    }
  ],
```
And in the require-dev section add:
```
"ion2s/laratomics-workshop": "*",
```

Then run:
```bash
composer update
```
You should see ion2s/laratomics-workshop in the list of discovered packages.
