<?php

declare(strict_types=1);

namespace App\Application\Query\Area\GetAreaById;

use App\Application\Query\Item;
use App\Application\Query\QueryHandlerInterface;
use App\Infrastructure\Area\Query\Mysql\MysqlAreaReadModelRepository;

class GetAreaByIdHandler implements QueryHandlerInterface
{
    /**
     * @throws \App\Domain\Shared\Query\Exception\NotFoundException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function __invoke(GetAreaByIdQuery $query): Item
    {
        $areaView = $this->repository->oneByUuid($query->uuid);

        return new Item($areaView);
    }

    public function __construct(MysqlAreaReadModelRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @var MysqlAreaReadModelRepository
     */
    private $repository;
}
