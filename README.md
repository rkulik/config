# config

Lightweight configuration file loader. Currently supporting PHP and JSON files.

- [Requirements](#requirements)
- [Install](#install)
- [Usage](#usage)
- [Testing](#testing)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [Security](#security)
- [Credits](#credits)
- [License](#license)

## Requirements

This package requires PHP 7.1 or higher.

## Install

Via composer:

``` bash
$ composer require rkulik/config
```

## Usage

### Instantiate basic configuration

``` php
<?php
// config.php

return [
    'hello' => 'world',
];
```

``` php
<?php
// index.php

require 'vendor/autoload.php';

$configFactory = new \Rkulik\Config\ConfigFactory();

$config = $configFactory->make('config.php');

echo $config->get('hello'); // world
```

### Instantiate configuration using custom parser

For special requirements, such as working with unsupported types of configuration files, using a custom parser is the suggested way to go.

``` php
<?php
// config.php

return [
    'hello' => 'world',
];
```

``` php
<?php
// CustomParser.php

use Rkulik\Config\FileParser\FileParserInterface;

class CustomParser implements FileParserInterface
{
    /**
     * {@inheritdoc}
     */
    public function parse(string $file): array
    {
        $data = require $file;
        
        array_walk($data, function (&$item) {
            $item = strrev($item);
        });

        return $data;
    }
}
```

``` php
<?php
// index.php

require 'vendor/autoload.php';
require 'CustomParser.php';

$configFactory = new \Rkulik\Config\ConfigFactory();
$customParser = new CustomParser();

$config = $configFactory->make('config.php', $customParser);

echo $config->get('hello'); // dlrow
```

### Using "dot" notation

Use "dot" notation to perform CRUD operations on configuration data.

``` php
<?php
// config.php

return [
    'hello' => [
        'beautiful' => 'world',
    ],
];
```

``` php
<?php
// index.php

require 'vendor/autoload.php';

$configFactory = new \Rkulik\Config\ConfigFactory();

$config = $configFactory->make('config.php');

echo $config->get('hello.beautiful'); // world
```

## Testing

``` bash
$ composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security-related issues, please email rene@kulik.io instead of using the issue tracker.

## Credits

- [René Kulik](https://github.com/rkulik)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
