<?php

use NBPFetch\NBPFetch;

require_once "vendor/autoload.php";

$NBPFetch = new NBPFetch();
$NBPFetchGoldPrice = $NBPFetch->goldRate();

echo "<pre>";

$currentGoldPrice = $NBPFetchGoldPrice->current();
echo "currentGoldPrice:\r\n";
print_r($currentGoldPrice);
echo $NBPFetchGoldPrice->getApiCaller()->getError() . "\r\n";

$todayGoldPrice = $NBPFetchGoldPrice->today();
echo "todayGoldPrice:\r\n";
print_r($todayGoldPrice);
echo $NBPFetchGoldPrice->getApiCaller()->getError() . "\r\n";

$last5GoldPrices = $NBPFetchGoldPrice->last(5)->getItems();
echo "last5GoldPrices:\r\n";
print_r($last5GoldPrices);
echo $NBPFetchGoldPrice->getApiCaller()->getError() . "\r\n";

$byDateGoldPrice1 = $NBPFetchGoldPrice->byDate("2019-07-01");
echo "byDateGoldPrice #1:\r\n";
print_r($byDateGoldPrice1);
echo $NBPFetchGoldPrice->getApiCaller()->getError() . "\r\n";

$byDateGoldPrice2 = $NBPFetchGoldPrice->byDate("2019-07-07");
echo "byDateGoldPrice #2:\r\n";
print_r($byDateGoldPrice2);
echo $NBPFetchGoldPrice->getApiCaller()->getError() . "\r\n";

$byDateRangeGoldPrice = $NBPFetchGoldPrice->byDateRange("2019-07-01", "2019-07-12")->getItems();
echo "byDateRangeGoldPrice:\r\n";
print_r($byDateRangeGoldPrice);
echo $NBPFetchGoldPrice->getApiCaller()->getError() . "\r\n";

echo "</pre>";