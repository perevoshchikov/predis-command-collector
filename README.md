# Anper\Predis\CommandCollector


## Install

``` bash
$ composer require anper/predis-command-collector
```

## Usage collector

``` php
use Anper\Predis\CommandCollector\Collector;

$client = new \Predis\Client(...);

$collector = new Collector($client);

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