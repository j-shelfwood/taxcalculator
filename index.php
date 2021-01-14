<?php

class TaxCalculator
{
    protected int $percentage;
    protected string $selectedCountry;
    protected array $allowedPercentages = [
        'nl' => [9, 21],
        'de' => [6, 19],
    ];

    public function __construct(int $percentage, string $countryCode)
    {
        $this->setSelectedCountry($countryCode);
        $this->setPercentage($percentage);
    }

    public function setSelectedCountry(string $countryCode = 'nl')
    {
        // Is de code bestaand
        if (! array_key_exists($countryCode, $this->allowedPercentages)) {
            exit('Country does not exist.');
        }

        $this->selectedCountry = $countryCode;
    }

    public function getPercentage()
    {
        return $this->percentage;
    }

    public function setPercentage(int $percentage)
    {
        if (! in_array($percentage, $this->allowedPercentages[$this->selectedCountry])) {
            exit('This percentage is not allowed for this Country');
        }

        $this->percentage = $percentage;
    }

    public function calculateTax(int $price)
    {
        return $price * ($this->percentage / 100);
    }

    public function calculateTaxInformation(int $price)
    {
        return [
            'incl_tax' => $price / 100 * (100 + $this->percentage),
            'excl_tax' => $price,
            'tax' => $this->calculateTax($price),
        ];
    }
}

// bedrag * 1.21
$productPrices = range(10, 200, 10);

$calculator = new TaxCalculator(19, 'nl');

var_dump($calculator);

// var_dump($calculator->calculateTax(100));
