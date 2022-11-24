<?php

namespace App\DataFixtures;

use App\Entity\ConversionRate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ConversionRateFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create();

        for ($i=0; $i < 10; $i++) { 
            $conversionRate = new ConversionRate();
            $conversionRate->setCurrencyA($faker->currencyCode());
            $conversionRate->setCurrencyB($faker->currencyCode());
            $conversionRate->setRate($faker->randomFloat());
            $conversionRate->setUpdatedAt(new \DateTimeImmutable());
            $manager->persist($conversionRate);
        }

        $manager->flush();
    }
}
