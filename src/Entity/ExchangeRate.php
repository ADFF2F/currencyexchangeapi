<?php

namespace App\Entity;

use App\Repository\ExchangeRateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ExchangeRateRepository::class)
 */
class ExchangeRate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Currency::class, inversedBy="exchangeRates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $exchangeFrom;

    /**
     * @ORM\ManyToOne(targetEntity=Currency::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $exchangeTo;

    /**
     * @ORM\Column(type="float")
     */
    private $rate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExchangeFrom(): ?Currency
    {
        return $this->exchangeFrom;
    }

    public function setExchangeFrom(?Currency $exchangeFrom): self
    {
        $this->exchangeFrom = $exchangeFrom;

        return $this;
    }

    public function getExchangeTo(): ?Currency
    {
        return $this->exchangeTo;
    }

    public function setExchangeTo(?Currency $exchangeTo): self
    {
        $this->exchangeTo = $exchangeTo;

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
}
