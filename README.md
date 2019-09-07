# NBPFetch [![Build Status](https://travis-ci.org/adamale/NBPFetch.svg?branch=master)](https://travis-ci.org/adamale/NBPFetch)
PHP library that helps to fetch data from NBP API - http://api.nbp.pl/en.html.  
It allows you to fetch currency rates, exchange rate tables and gold prices.

## Requirements
PHP 7.2 or above.

## Installation
a) with Composer:
``` bash
composer require adamale/nbpfetch
```
b) without Composer:  
include [Composer File Loader](https://github.com/Wilkins/composer-file-loader) in your project to autoload all the necessary classes.

## Usage

### Currency rate
```php
<?php

use NBPFetch\Module\CurrencyRate\CurrencyRate;

require_once "vendor/autoload.php";

/**
 * Currency rate examples.
 * Available methods are: current(), today(), byDate(string $date),
 * byDateRange(string $from, string $to) and last(string $currency, int count).
 */
try {
    $currencyRate = new CurrencyRate("EUR");

    $currentCurrencyRate = $currencyRate->current();
    $todayCurrencyRate = $currencyRate->today();
    $givenDateCurrencyRate = $currencyRate->byDate("2019-08-27");
    $givenDateRangeCurrencyRates = $currencyRate->byDateRange("2019-08-01", "2019-08-30");
    $last10CurrencyRates = $currencyRate->last(10);
} catch (Exception $e) {
}
```

### Exchange rate table
```php
<?php

use NBPFetch\Module\ExchangeRateTable\ExchangeRateTable;

require_once "vendor/autoload.php";

/**
 * Exchange rate table examples.
 * Available methods are: current(), today(), byDate(string $date),
 * byDateRange(string $from, string $to) and last(string $currency, int count).
 */
try {
    $exchangeRateTable = new ExchangeRateTable("A");

    $currentExchangeRateTable = $exchangeRateTable->current();
    $todayExchangeRateTable = $exchangeRateTable->today();
    $givenDateExchangeRateTable = $exchangeRateTable->byDate("2019-08-27");
    $givenDateRangeExchangeRateTables = $exchangeRateTable->byDateRange("2019-08-01", "2019-08-30");
    $last10ExchangeRateTables = $exchangeRateTable->last(10);
} catch (Exception $e) {
}

```

### Gold price
```php
<?php

use NBPFetch\Module\GoldPrice\GoldPrice;

require_once "vendor/autoload.php";

/**
 * Gold price examples.
 * Available methods are: current(), today(), byDate(string $date),
 * byDateRange(string $from, string $to) and last(string $currency, int count).
 */
try {
    $goldPrice = new GoldPrice();

    $currentGoldPrice = $goldPrice->current();
    $todayGoldPrice = $goldPrice->today();
    $givenDateGoldPrice = $goldPrice->byDate("2019-08-27");
    $givenDateRangeGoldPrices = $goldPrice->byDateRange("2019-08-01", "2019-08-30");
    $last10GoldPrices = $goldPrice->last(10);
} catch (Exception $e) {
}
```

## About

### Author
Adam Aleksak <kontakt@adamaleksak.pl>

### License
NBPFetch is licensed under the MIT License - see the `LICENSE` file for the details.