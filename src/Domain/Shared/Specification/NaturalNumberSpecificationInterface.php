<?php

declare(strict_types=1);

namespace App\Domain\Shared\Specification;

use App\Domain\Shared\Exception\NotNaturalNumberException;

interface NaturalNumberSpecificationInterface
{
    /**
     * @throws NotNaturalNumberException
     */
    public function isNatural(int $value): bool;
}
