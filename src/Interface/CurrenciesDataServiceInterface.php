<?php

namespace App\Interface;

interface CurrenciesDataServiceInterface {

    public function getConversionRate(string $currA, string $currB): float;

    public function setConversionRate(float $rate): void;

}