<?php

declare(strict_types=1);

namespace App\Infrastructure\Area\Repository;

use App\Domain\Area\Area;
use App\Domain\Area\Repository\AreaRepositoryInterface;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use Ramsey\Uuid\UuidInterface;

final class AreaStore extends EventSourcingRepository implements AreaRepositoryInterface
{
    public function store(Area $area): void
    {
        $this->save($area);
    }

    public function get(UuidInterface $uuid): Area
    {
        /** @var Area $area */
        $area = $this->load($uuid->toString());

        return $area;
    }

    public function __construct(
        EventStore $eventStore,
        EventBus $eventBus,
        array $eventStreamDecorators = []
    ) {
        parent::__construct(
            $eventStore,
            $eventBus,
            Area::class,
            new PublicConstructorAggregateFactory(),
            $eventStreamDecorators
        );
    }
}
