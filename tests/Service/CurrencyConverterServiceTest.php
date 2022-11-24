<?php

use App\Interface\CurrenciesDataServiceInterface;
use App\Service\CurrencyConverterService;
use PHPUnit\Framework\TestCase;

final class CurrencyConverterServiceTest extends TestCase {

    protected CurrenciesDataServiceInterface $currenciesDataService;

    protected function setUp(): void
    {
        $currenciesDataService = new class implements CurrenciesDataServiceInterface {
            private float $euroDollarRate = 0.0;
            public function getConversionRate(string $currA, string $currB): float {
                return $this->euroDollarRate;
            }

            public function setConversionRate(float $rate): void {
                $this->euroDollarRate = $rate;
            }
        };
        $this->currenciesDataService = $currenciesDataService;
    }

    public function testConvertEurToDollarReturnsAFloat() {
        $service = new CurrencyConverterService($this->currenciesDataService);
        $actual = $service->convertEurToDollar(99);
        $this->assertIsFloat($actual);
    }

    public function testConvertEurToDollarConvertsToCorrectRate() {
        $expected = 0.9;
        $this->currenciesDataService->setConversionRate($expected);
        $service = new CurrencyConverterService($this->currenciesDataService);
        $actual = $service->convertEurToDollar(1);
        $this->assertEquals($expected, $actual);
    }

}