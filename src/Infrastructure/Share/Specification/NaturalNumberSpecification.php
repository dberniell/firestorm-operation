<?php

declare(strict_types=1);

namespace App\Infrastructure\Share\Specification;

use App\Domain\Shared\Exception\NotNaturalNumberException;
use App\Domain\Shared\Specification\AbstractSpecification;
use App\Domain\Shared\Specification\NaturalNumberSpecificationInterface;

final class NaturalNumberSpecification extends AbstractSpecification implements NaturalNumberSpecificationInterface
{
    /**
     * @param int $number
     * @return bool
     * @throws NotNaturalNumberException
     */
    public function isNatural(int $number): bool
    {
        return $this->isSatisfiedBy($number);
    }

    /**
     * @param int $value
     * @throws NotNaturalNumberException
     */
    public function isSatisfiedBy($value): bool
    {
        if (!(is_numeric($value) && $value > 0 && $value == round($value))) {
            throw new NotNaturalNumberException();
        }

        return true;
    }

    public function __construct()
    {
    }
}
