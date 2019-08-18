# NBPFetch [![Build Status](https://travis-ci.org/adamale/NBPFetch.svg?branch=master)](https://travis-ci.org/adamale/NBPFetch)
PHP library that helps to fetch data from NBP API - http://api.nbp.pl/en.html.  
It allows you to fetch gold prices and exchange rate tables.

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

use NBPFetch\NBPFetch;
use NBPFetch\Structure\ExchangeRate\ExchangeRate;

require_once "vendor/autoload.php";

$NBPFetch = new NBPFetch();
$NBPFetchGoldPrice = $NBPFetch->goldPrice(); // for gold prices
$NBPFetchExchangeRateTable = $NBPFetch->exchangeRateTable(); // for exchange rate tables

/**
 * Single gold price result.
 * Available methods are: current(), today() and byDate(string $date).
 */
print("Single gold price result example:\n");
try {
    $currentGoldPrice = $NBPFetchGoldPrice->current();

    printf(
        "Current gold price is %s, published on %s.\n",
        $currentGoldPrice->getPrice(),
        $currentGoldPrice->getDate()
    );
} catch (InvalidArgumentException|UnexpectedValueException $e) {
    printf("%s.\n", $e->getMessage());
}

/**
 * Collection of gold price results.
 * Available methods are: byDateRange(string $from, string $to) and last(int count).
 */
print("\nCollection of gold price results example:\n");
try {
    $byDateRangeGoldPrices = $NBPFetchGoldPrice->byDateRange("2019-07-01", "2019-07-12");

    foreach ($byDateRangeGoldPrices as $byDateRangeGoldPrice) {
        printf(
            "The gold price on %s was %s.\n",
            $byDateRangeGoldPrice->getDate(),
            $byDateRangeGoldPrice->getPrice()
        );
    }
} catch (InvalidArgumentException|UnexpectedValueException $e) {
    printf("%s.\n", $e->getMessage());
}

/**
 * Single exchange rate table result.
 * Available methods are: current(string $table), today(string $table)
 * and byDate(string $table, string $date).
 */
print("\nSingle exchange rate table result example:\n");
try {
    $currentExchangeRateTable = $NBPFetchExchangeRateTable->current("A");
    $exchangeRateCollection = $currentExchangeRateTable->getExchangeRateCollection();
    /**
     * @var ExchangeRate $firstFoundCurrency
     */
    $firstFoundCurrency = $exchangeRateCollection[0];

    printf(
        "Current exchange rate table number is %s, published on %s.\n",
        $currentExchangeRateTable->getNumber(),
        $currentExchangeRateTable->getDate()
    );
    printf(
        "It has %s currencies listed.\n",
        count($exchangeRateCollection)
    );
    printf(
        "First found currency is %s rated %s.\n",
        $firstFoundCurrency->getCode(),
        $firstFoundCurrency->getRate()
    );
} catch (InvalidArgumentException|UnexpectedValueException $e) {
    printf("%s.\n", $e->getMessage());
}

/**
 * Collection of exchange rate tables.
 * Available methods are: byDateRange(string $table, string $from, string $to)
 * and last(string $table, int count).
 */
print("\nCollection of exchange rate table results example:\n");
try {
    $byDateRangeExchangeRateTables = $NBPFetchExchangeRateTable->byDateRange("A", "2019-08-01", "2019-08-12");

    foreach ($byDateRangeExchangeRateTables as $byDateRangeExchangeRateTable) {
        printf(
            "The exchange rate table from %s has a number %s.\n",
            $byDateRangeExchangeRateTable->getDate(),
            $byDateRangeExchangeRateTable->getNumber()
        );
    }
} catch (InvalidArgumentException|UnexpectedValueException $e) {
    printf("%s.\n", $e->getMessage());
}

/**
 * Example of thrown InvalidArgumentException - custom message from library.
 */
print("\nExample of thrown InvalidArgumentException:\n");
try {
    $date = date("Y-m-d", strtotime("+1 month"));
    $NBPFetchGoldPrice->byDate($date);
} catch (InvalidArgumentException|UnexpectedValueException $e) {
    printf("%s.\n", $e->getMessage());
}

/**
 * Example of thrown UnexpectedValueException - message straight from NBP API.
 */
print("\nExample of thrown UnexpectedValueException:\n");
try {
    $NBPFetchGoldPrice->byDate("2019-07-06");
} catch (InvalidArgumentException|UnexpectedValueException $e) {
    printf("%s.\n", $e->getMessage());
}
```

## About

### Author
Adam Aleksak <kontakt@adamaleksak.pl>

### License
NBPFetch is licensed under the MIT License - see the `LICENSE` file for the details.