<?php

class Converter
{

    private $rateValue;

    //I have base these rates on USD :)
    private $rates = [
        'INR' => 67.15,
        'USD' => 1.0,
        'GBP' => 0.74,
        'EUR' => 0.84,
        'YEN' => 109.55,
        'CAN' => 1.28,
        'PHP' => 52.07,
    ];

    public function setConvert($amount, $currency_from)
    {
        $this->rateValue = $amount / $this->rates[$currency_from];
    }

    public function getConvert($currency_to)
    {
        return round($this->rates[$currency_to] * $this->rateValue, 2);
    }

    public function getRates()
    {
        return $this->rates;
    }
}

?>