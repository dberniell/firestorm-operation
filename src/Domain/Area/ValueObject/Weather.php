<?php

declare(strict_types=1);

namespace App\Domain\Area\ValueObject;

class Weather
{
    /**
     * @param string $weather
     * @return Weather
     */
    public static function fromString(string $weather): self
    {
        $weather = json_decode($weather, true);
        $weath = new self();

        $weath->wind = $weather['wind'];
        $weath->humidity = $weather['humidity'];

        return $weath;
    }

    public function toArray(): array
    {
        $weather = [
            "wind" => $this->wind,
            "humidity" => $this->humidity
        ];

        return $weather;
    }

    public function __toString(): string
    {
        $weather = [
            "wind" => $this->wind,
            "humidity" => $this->humidity
        ];

        return json_encode($weather);
    }

    private function __construct()
    {
    }

    /** @var string */
    private $wind;

    /** @var string */
    private $humidity;
}
