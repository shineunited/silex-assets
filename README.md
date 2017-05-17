Silex Assets
============

A Silex package for managing local and remote static assets.


Installation
------------

The recommended way to install silex-assets is through composer:

```bash
$ composer require shineunited/silex-assets
```


Configuration
-------------

```php
require_once(__DIR__ . '/../vendor.autoload.php');

use Silex\Application;
use ShineUnited\Silex\Assets\AssetManagerServiceProvider;

$app->register(new AssetManagerServiceProvider(), [
	'assets.path' => '/path/to/assets/'
]);
```



Usage
-----

Accessing prefixed assets
```php
echo $app['assets']->lookup('my/asset.txt');
// returns: /path/to/assets/my/asset.txt
```

Mapping additional assets
```php
$app['assets']->map('jquery.js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js');

echo $app['assets']->lookup('jquery.js');
// returns: https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js
```
