<?php

namespace App\Entity;

use App\Repository\ConversionRateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConversionRateRepository::class)]
class ConversionRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 3)]
    private $currencyA;

    #[ORM\Column(type: 'string', length: 3)]
    private $currencyB;

    #[ORM\Column(type: 'float')]
    private $rate;

    #[ORM\Column(type: 'datetime_immutable')]
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrencyA(): ?string
    {
        return $this->currencyA;
    }

    public function setCurrencyA(string $currencyA): self
    {
        $this->currencyA = $currencyA;

        return $this;
    }

    public function getCurrencyB(): ?string
    {
        return $this->currencyB;
    }

    public function setCurrencyB(string $currencyB): self
    {
        $this->currencyB = $currencyB;

        return $this;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
