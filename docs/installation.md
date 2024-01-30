# Installation

## Composer Installation

Myth:db is intended to be installed via Composer, and should be added as a requirement to your `composer.json` file:

```bash
composer require myth/db
```

## Manual Installation

You can manually install the library if you prefer. In the following example, we will assume that all files have been installed into `app/ThirdParty/myth-db` folder.

Download this project and then enable it by editing the ` app/Config/Autoload.php`` file and adding the  `Myth\DB`namespace to the`$psr4`array, as well as tell it to load the`Common` file:

```php
<?php

...

public $psr4 = [
    APP_NAMESPACE => APPPATH, // For custom app namespace
    'Config'      => APPPATH . 'Config',
    'Myth\DB'     => APPPATH . 'ThirdParty/myth-db/src',
];

...

public $files = [
    APPPATH . 'ThirdParty/myth-db/src/Common.php',
];
```
