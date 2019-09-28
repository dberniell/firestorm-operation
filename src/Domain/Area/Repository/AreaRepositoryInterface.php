<?php

declare(strict_types=1);

namespace App\Domain\Area\Repository;

use App\Domain\Area\Area;
use Ramsey\Uuid\UuidInterface;

interface AreaRepositoryInterface
{
    public function get(UuidInterface $uuid): Area;

    public function store(Area $area): void;
}
