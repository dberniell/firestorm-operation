<?php

declare(strict_types=1);

namespace App\Application\Command\Area\CalculateArea;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class CalculateAreaCommand
{
    /**
     * @var UuidInterface
     */
    public $uuid;

    /**
     * @var int
     */
    public $natural;

    /**
     * @param string $uuid
     * @param int $natural
     */
    public function __construct(string $uuid, int $natural)
    {
        $this->uuid = Uuid::fromString($uuid);
        $this->natural = $natural;
    }
}
