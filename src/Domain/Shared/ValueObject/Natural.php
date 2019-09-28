<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Exception\NotNaturalNumberException;
use App\Infrastructure\Share\Specification\NaturalNumberSpecification;

class Natural
{
    /**
     * @throws NotNaturalNumberException
     */
    public static function fromInteger(int $value): self
    {
        $assertion = new NaturalNumberSpecification();
        $assertion->isNatural($value);

        $natural = new self();

        $natural->natural = $value;

        return $natural;
    }

    public function toInteger(): int
    {
        return (int) $this->natural;
    }

    private function __construct()
    {
    }

    /** @var int */
    private $natural;
}
