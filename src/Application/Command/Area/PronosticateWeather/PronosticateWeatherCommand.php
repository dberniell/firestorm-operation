<?php

declare(strict_types=1);

namespace App\Application\Command\Area\PronosticateWeather;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class PronosticateWeatherCommand
{
    /**
     * @var UuidInterface
     */
    public $uuid;

    /**
     * @param string $uuid
     */
    public function __construct(string $uuid)
    {
        $this->uuid = Uuid::fromString($uuid);
    }
}
