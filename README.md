Google Civic API Client
=======================
 
This is a minimalistic API client for Google Civic API

Installation
------------

Installation is conveniently provided via Composer.

To get started, install composer in your project:

```sh
$ curl -s https://getcomposer.org/installer | php
```

Next, add a composer.json file containing the following:

```js
}
    "require": {
        "google/civic-client": "dev-master"
    }
}
```

Finally, install!

```sh
$ php composer.phar install
```

Usage
-----

Using the Google Civic client is easy:

``` php

<?php

require_once '../src/Client.php';

try {
    $client = new GoolgeCivic('YOUR API KEY');
    $result = $client->getElections();
} catch (Exception $e) {
    echo $e->getMessage();
}
print_r($result);

```