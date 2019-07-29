# NBPFetch [![Build Status](https://travis-ci.org/adamale/NBPFetch.svg?branch=master)](https://travis-ci.org/adamale/NBPFetch)

PHP library that helps to fetch data from NBP API - http://api.nbp.pl/. 

## Installation
``` bash
$ composer require adamale/nbpfetch
```

## Usage
```php
<?php

use NBPFetch\NBPFetch;

require_once "vendor/autoload.php";

$NBPFetch = new NBPFetch();
$NBPFetchGoldPrice = $NBPFetch->goldPrice();

/**
 * Single gold price result.
 * Available methods are: current(), today() and byDate(string $date)
 */
$currentGoldPrice = $NBPFetchGoldPrice->current();
echo "Current gold price is " . $currentGoldPrice->getPrice() . ", published on " . $currentGoldPrice->getDate() . ".\n";

/**
 * Collection of gold price results.
 * Available methods are: byDateRange(string $from, string $to) and last(int count)
 */
$byDateRangeGoldPrices = $NBPFetchGoldPrice->byDateRange("2019-07-01", "2019-07-12");
foreach ($byDateRangeGoldPrices as $byDateRangeGoldPrice) {
    echo "The gold price on " . $byDateRangeGoldPrice->getDate() . " was " . $byDateRangeGoldPrice->getPrice() . ".\n";
}

/** 
 * Error message is available in case the proper response was not created
 * (method returned null instead of object).
 */
$errorMessage = $NBPFetchGoldPrice->getApiCaller()->getError();
```

## About

### Requirements

PHP 7.2 or above.

### Author

Adam Aleksak <kontakt@adamaleksak.pl>

### License

NBPFetch is licensed under the MIT License - see the `LICENSE` file for details.