<p align="center">
<h1>Laratomics Workshop</h1>
</p>

<p align="center">
<a href="https://travis-ci.org/poolingpeople/laratomics-workshop"><img src="https://travis-ci.org/poolingpeople/laratomics-workshop.svg?branch=1.0" alt="Build Status"></a>
<a href="https://packagist.org/packages/poolingpeople/laratomics-workshop"><img src="https://poser.pugx.org/poolingpeople/laratomics-workshop/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/poolingpeople/laratomics-workshop"><img src="https://poser.pugx.org/poolingpeople/laratomics-workshop/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/poolingpeople/laratomics-workshop"><img src="https://poser.pugx.org/poolingpeople/laratomics-workshop/license.svg" alt="License"></a>
</p>

## Introduction
Laratomics Workshop enables a development GUI besides your current project.
Using this GUI you can create and manage template snippets (patterns) and build your whole frontend
using these reusable patterns.

## Installation & Configuration

### Installation
Laratomics Workshop is not yet available. So there is no straight forward installation process.
Stay tuned.

### Configuration
#### .env configuration
```
WORKSHOP_URI=workshop
WORKSHOP_BASE_PATH=laratomics
WORKSHOP_PATTERN_PATH="${WORKSHOP_BASE_PATH}/patterns"
```

#### Add a custom disk
In `config/filesystems.php` add:
```php
'disks' => [

        'patterns' => [
            'driver' => 'local',
            'root' => base_path('resources/laratomics/patterns')
        ],
```

## Credits
* [ion2s GmbH](https://github.com/poolingpeople)
* [All Contributors](https://github.com/poolingpeople/laratomics-workshop/graphs/contributors)

## Security Vulnerabilities
If you discover a security vulnerability within laratomics-workshop, please send an e-mail to Sebastian Baum via [sebastian.baum@ion2s.com](mailto:sebastian.baum@ion2s.com).

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.