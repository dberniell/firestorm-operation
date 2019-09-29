<?php


namespace App\Domain\Area\Service;


use App\Domain\Shared\ValueObject\Natural;

final class TrapezoidalRule
{
    /**
     * @param Natural $divider
     * @return float|int
     */
    public static function calculateArea(Natural $divider)
    {
        $h = (self::x2 - self::x1) / $divider->toInteger();
        $self = new TrapezoidalRule();
        $result = $h * ((($self->hyperbolicFunction(self::x1) + $self->hyperbolicFunction(self::x2)) / 2) +
                $self->sumOfDivisions($h, $divider->toInteger()));

        return $result;
    }

    /**
     * @param int $x
     * @return float
     */
    private function hyperbolicFunction(int $x): float
    {
        return (1 / $x);
    }

    /**
     * @param float $h
     * @param int $divisions
     * @return float
     */
    private function sumOfDivisions(float $h, int $divisions): float
    {
        $sum = 0;
        for ($i = 1; $i < $divisions - 1; $i++) {
            $point = self::x1 + $i * $h;
            $sum += 2 * $this->hyperbolicFunction($point);
        }

        return $sum;
    }

    const x1 = 2;

    const x2 = 3;
}