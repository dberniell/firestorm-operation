<?php

declare(strict_types=1);

namespace App\Infrastructure\Area\Query;

use App\Domain\Area\Event\AreaWasCalculated;
use App\Domain\Area\Event\WeatherWasPronosticated;
use App\Infrastructure\Area\Query\Mysql\MysqlAreaReadModelRepository;
use App\Infrastructure\Area\Query\Projections\AreaView;
use Broadway\ReadModel\Projector;

class AreaProjectionFactory extends Projector
{
    /**
     * @throws \Assert\AssertionFailedException
     * @throws \App\Domain\Shared\Exception\DateTimeException
     */
    protected function applyAreaWasCreated(AreaWasCreated $areaWasCreated): void
    {

    }

    /**
     * @throws \App\Domain\Shared\Query\Exception\NotFoundException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    protected function applyAreaWasCalculated(AreaWasCalculated $areaCalculated): void
    {
        $areaReadModel = AreaView::fromSerializable($areaCalculated);

        $this->repository->add($areaReadModel);
    }

    /**
     * @throws \App\Domain\Shared\Query\Exception\NotFoundException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    protected function applyWeatherWasPronosticated(WeatherWasPronosticated $weatherPronosticated): void
    {
        /** @var AreaView $areaReadModel */
        $areaReadModel = $this->repository->oneByUuid($weatherPronosticated->uuid);

        $areaReadModel->weatherPronosticated($weatherPronosticated->weather);
        $areaReadModel->changeUpdatedAt($weatherPronosticated->createdAt);

        $this->repository->apply();
    }

    public function __construct(MysqlAreaReadModelRepository $repository)
    {
        $this->repository = $repository;
    }

    /** @var MysqlAreaReadModelRepository */
    private $repository;
}
