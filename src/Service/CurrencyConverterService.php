<?php

namespace App\Service;

use App\Interface\CurrenciesDataServiceInterface;

final class CurrencyConverterService {

    const EUR = 'EUR';
    const USD = 'USD';
    const YEN = 'JPY';

    public function __construct(private CurrenciesDataServiceInterface $currenciesDataService)
    {
    }

    public function convertEurToDollar(float $euroPrice): float {
        return $this->currenciesDataService->getConversionRate(self::EUR, self::USD) * $euroPrice;
    }

    public function convertEurToYen(float $euroPrice): float {
        return $this->currenciesDataService->getConversionRate(self::EUR, self::YEN) * $euroPrice;
    }


    // TODO save requests for an API rate in DB

}