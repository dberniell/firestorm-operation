<?php

declare(strict_types=1);

namespace App\Domain\Shared\Exception;

class NotNaturalNumberException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Value is not a natural number.');
    }
}
