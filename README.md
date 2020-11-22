# Anper\Predis\CommandCollector

[![Software License][ico-license]](LICENSE.md)
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Build Status][ico-ga]][link-ga]

## Install

``` bash
$ composer require anper/predis-command-collector
```

## Usage collector

``` php
use Anper\Predis\CommandCollector\Collector;
use function Anper\Predis\CommandCollector\register_collector;

$client = new \Predis\Client(...);

register_collector($client, $collector = new Collector($client));

// redis queries...

foreach($collector->getProfiles() as $profile) {
    echo $profile->getCommandAsString();
}
```

## Usage function

``` php
use Anper\Predis\CommandCollector\Profile;

use function Anper\Predis\CommandCollector\register_collector;

$collector = function (Profile $profile) {
    echo $profile->getCommandAsString();
};

register_collector($client, $collector);
```

## Test

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/anper/predis-command-collector.svg
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg
[ico-ga]: https://github.com/perevoshchikov/predis-command-collector/workflows/Tests/badge.svg

[link-packagist]: https://packagist.org/packages/anper/predis-command-collector
[link-ga]: https://github.com/perevoshchikov/predis-command-collector/actions
