# NBPFetch [![Build Status](https://travis-ci.org/adamale/NBPFetch.svg?branch=master)](https://travis-ci.org/adamale/NBPFetch)
PHP library that helps to fetch data from NBP API - http://api.nbp.pl/. 

## Requirements
PHP 7.2 or above.

## Installation
a) preferred way - with Composer:
``` bash
composer require adamale/nbpfetch
```
b) harder way - without Composer:  
include [Composer File Loader](https://github.com/Wilkins/composer-file-loader) in your project to autoload all necessary classes.

## Usage
```php
<?php

use NBPFetch\NBPApi\Exception\InvalidResponseException;
use NBPFetch\NBPFetch;

require_once "vendor/autoload.php";

$NBPFetch = new NBPFetch();
$NBPFetchGoldPrice = $NBPFetch->goldPrice();

/**
 * Single gold price result.
 * Available methods are: current(), today() and byDate(string $date).
 */
try {
    echo "Single gold price result:\n";
    $currentGoldPrice = $NBPFetchGoldPrice->current();
    echo "Current gold price is " . $currentGoldPrice->getPrice() . ", published on " . $currentGoldPrice->getDate() . ".\n";
} catch (InvalidArgumentException|InvalidResponseException $e) {
    echo $e->getMessage() . ".\n";
}

/**
 * Collection of gold price results.
 * Available methods are: byDateRange(string $from, string $to) and last(int count).
 */
try {
    echo "Collection of gold price results:\n";
    $byDateRangeGoldPrices = $NBPFetchGoldPrice->byDateRange("2019-07-01", "2019-07-12");
    foreach ($byDateRangeGoldPrices as $byDateRangeGoldPrice) {
        echo "The gold price on " . $byDateRangeGoldPrice->getDate() . " was " . $byDateRangeGoldPrice->getPrice() . ".\n";
    }
} catch (InvalidArgumentException|InvalidResponseException $e) {
    echo $e->getMessage() . ".\n";
}

/**
 * Example of thrown InvalidArgumentException - custom message from library.
 */
try {
    echo "Example of thrown InvalidArgumentException:\n";
    $date = date("Y-m-d", strtotime("+1 month"));
    $NBPFetchGoldPrice->byDate($date);
} catch (InvalidArgumentException|InvalidResponseException $e) {
    echo $e->getMessage() . ".\n";
}

/**
 * Example of thrown InvalidResponseException - message straight from NBP API.
 */
try {
    echo "Example of thrown InvalidResponseException:\n";
    $NBPFetchGoldPrice->byDate("2019-07-06");
} catch (InvalidArgumentException|InvalidResponseException $e) {
    echo $e->getMessage() . ".\n";
}
```

## About

### Author
Adam Aleksak <kontakt@adamaleksak.pl>

### License
NBPFetch is licensed under the MIT License - see the `LICENSE` file for the details.