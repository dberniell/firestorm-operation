<?php

declare(strict_types=1);

namespace App\Application\Query\Area\GetAreaById;

use App\Application\Query\Item;
use App\Application\Query\QueryHandlerInterface;
use App\Domain\Area\Event\WeatherWasPronosticated;
use App\Domain\Area\ValueObject\Weather;
use App\Domain\Shared\ValueObject\DateTime;
use App\Infrastructure\Area\Query\Mysql\MysqlAreaReadModelRepository;
use App\Infrastructure\Area\Query\Projections\AreaView;
use App\Infrastructure\Share\OpenWeather\OpenWeather;
use Broadway\EventDispatcher\CallableEventDispatcher;
use Broadway\EventDispatcher\EventDispatcher;
use Ramsey\Uuid\Uuid;

class GetAreaByIdHandler implements QueryHandlerInterface
{
    /**
     * @throws \App\Domain\Shared\Query\Exception\NotFoundException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function __invoke(GetAreaByIdQuery $query): Item
    {
        $forecast = $this->openWeather->pronosticate();
        /** @var AreaView $areaView */
        $areaView = $this->repository->oneByUuid($query->uuid);

        $areaView->weatherPronosticated(Weather::fromString($forecast));

        return new Item($areaView);
    }

    public function __construct(MysqlAreaReadModelRepository $repository, OpenWeather $openWeather)
    {
        $this->repository = $repository;
        $this->openWeather = $openWeather;
        $this->eventDispatcher = new CallableEventDispatcher();
    }

    /**
     * @var MysqlAreaReadModelRepository
     */
    private $repository;

    /**
     * @var OpenWeather
     */
    private $openWeather;

    /**
     * @var CallableEventDispatcher
     */
    private $eventDispatcher;
}
