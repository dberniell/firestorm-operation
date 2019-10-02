<?php

declare(strict_types=1);

namespace App\Application\Command\Area\PronosticateWeather;

use App\Application\Command\Area\CalculateArea\CalculateAreaCommand;
use App\Application\Command\CommandHandlerInterface;
use App\Domain\Area\Area;
use App\Domain\Area\Event\WeatherWasPronosticated;
use App\Domain\Area\Repository\AreaRepositoryInterface;
use App\Domain\Area\ValueObject\Weather;
use App\Domain\Shared\ValueObject\DateTime;
use App\Infrastructure\Share\OpenWeather\OpenWeather;
use Ramsey\Uuid\UuidInterface;

class PronosticateWeatherHandler implements CommandHandlerInterface
{
    public function __invoke(PronosticateWeatherCommand $command): void
    {
        /** @var UuidInterface $uuid */
        $uuid = $command->uuid;

        $area = $this->areaStore->get($uuid);

        $forecast = $this->openWeather->pronosticate();

        $area->apply(new WeatherWasPronosticated($uuid, Weather::fromString($forecast), DateTime::now()));
        $this->areaStore->store($area);
    }

    public function __construct(AreaRepositoryInterface $areaStore, OpenWeather $openWeather)
    {
        $this->areaStore = $areaStore;
        $this->openWeather = $openWeather;
    }

    /**
     * @var AreaRepositoryInterface
     */
    private $areaStore;

    /**
     * @var OpenWeather
     */
    private $openWeather;
}
