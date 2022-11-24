<?php

namespace App\Service;

use App\Entity\ConversionRate;
use App\Interface\CurrenciesDataServiceInterface;
use App\Repository\ConversionRateRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class CurrenciesDataService implements CurrenciesDataServiceInterface {

    private float $rate = 0.0;

    public function __construct(private HttpClientInterface $client, private ConversionRateRepository $conversionRateRepository)
    {
    }

    public function getConversionRate(string $currA, string $currB): float
    {
        $conversionRate = 1.0;
        $conversionRateEntity = $this->conversionRateRepository->findOneByConversion($currA, $currB);
        $last24Hours = (new \DateTimeImmutable('today midnight'));
        if (!empty($conversionRateEntity)
            && $conversionRateEntity->getUpdatedAt()->getTimestamp() > $last24Hours->getTimestamp()
        ) {
            $conversionRate = $conversionRateEntity->getRate();
        } else {
            $response = $this->client->request(
                'GET',
                'https://v6.exchangerate-api.com/v6/' . $_ENV['EXCHANGE_RATE_API_KEY'] . '/pair/'. $currA .'/' . $currB
            );
            $conversionRate = $response->toArray()['conversion_rate'];
            if (empty($conversionRateEntity)) {   
                $conversionRateEntity = new ConversionRate();
                $conversionRateEntity->setCurrencyA($currA);
                $conversionRateEntity->setCurrencyB($currB);
            }
            $conversionRateEntity->setRate($conversionRate);
            $conversionRateEntity->setUpdatedAt(new \DateTimeImmutable());
            $this->conversionRateRepository->add($conversionRateEntity, true);
        }
        $this->setConversionRate($conversionRate);
        return $this->rate;
    }

    public function setConversionRate(float $rate): void
    {
        $this->rate = $rate;
    }

}