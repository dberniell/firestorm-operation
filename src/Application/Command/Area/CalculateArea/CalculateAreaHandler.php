<?php

declare(strict_types=1);

namespace App\Application\Command\Area\CalculateArea;

use App\Application\Command\Area\CalculateArea\CalculateAreaCommand;
use App\Application\Command\CommandHandlerInterface;
use App\Domain\Area\Area;
use App\Domain\Area\Repository\AreaRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class CalculateAreaHandler implements CommandHandlerInterface
{
    public function __invoke(CalculateAreaCommand $command): void
    {
        /** @var UuidInterface $uuid */
        $uuid = $command->uuid;
        $natural = $command->natural;

        $area = Area::create($uuid, $natural);

        $this->areaStore->store($area);
    }

    public function __construct(AreaRepositoryInterface $areaStore)
    {
        $this->areaStore = $areaStore;
    }

    /**
     * @var AreaRepositoryInterface
     */
    private $areaStore;
}
