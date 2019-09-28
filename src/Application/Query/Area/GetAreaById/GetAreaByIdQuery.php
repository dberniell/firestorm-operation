<?php

namespace App\Application\Query\Area\GetAreaById;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class GetAreaByIdQuery
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
