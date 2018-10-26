# Setup

1. Create a standard Laravel application.
2. Link the package laratomics-brew in composer.json

## Recommended folder structure
* laratomics
    * packages
        * laratomics-brew
    * laravel

This structure will be created in the following steps.

### Laratomics-brew
```bash
mkdir -p laratomics/packages
git clone git@github.com:poolingpeople/laratomics-brew.git
```

### Laravel
Setup a plain Laravel 5.7+ application following the instructions in the [official documentation](https://laravel.com/docs/5.7/installation#installing-laravel)
```bash
composer create-project --prefer-dist laravel/laravel laravel
```

### Link the package
Finally you have to link the laravel-brew package in the Laravel application and you're ready to go.
In Laravel's composer.json add:
```
"repositories": [
    {
      "type":"path",
      "url":"/path/to/laratomics-brew"
    }
  ],
```

## Credits
* [ion2s GmbH](https://github.com/poolingpeople)
* [All Contributors](https://github.com/poolingpeople/laratomics-brew/graphs/contributors)

## Security Vulnerabilities
If you discover a security vulnerability within laratomics-brew, please send an e-mail to Sebastian Baum via [sebastian.baum@ion2s.com](mailto:sebastian.baum@ion2s.com).

## License
The MIT License (MIT). Please see [License File](LICENSE) for more information.