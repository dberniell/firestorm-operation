<?php

declare(strict_types=1);

namespace App\Infrastructure\Area\Query\Mysql;

use App\Infrastructure\Share\Query\Repository\MysqlRepository;
use App\Infrastructure\Area\Query\Projections\AreaView;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

final class MysqlAreaReadModelRepository extends MysqlRepository
{
    /**
     * @throws \App\Domain\Shared\Query\Exception\NotFoundException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function oneByUuid(UuidInterface $uuid): AreaView
    {
        $qb = $this->repository
            ->createQueryBuilder('area')
            ->where('area.uuid = :uuid')
            ->setParameter('uuid', $uuid->getBytes())
        ;

        return $this->oneOrException($qb);
    }

    public function add(AreaView $areaRead): void
    {
        $this->register($areaRead);
    }

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->class = AreaView::class;
        parent::__construct($entityManager);
    }
}
