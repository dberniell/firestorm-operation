<?php

declare(strict_types=1);

namespace App\Domain\Area;

use App\Domain\Area\Event\AreaWasCalculated;
use App\Domain\Area\Event\WeatherWasPronosticated;
use App\Domain\Area\Service\TrapezoidalRule;
use App\Domain\Shared\Specification\NaturalNumberSpecificationInterface;
use App\Domain\Shared\ValueObject\DateTime;
use App\Domain\Shared\ValueObject\Natural;
use App\Domain\Area\ValueObject\Weather;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Ramsey\Uuid\UuidInterface;

class Area extends EventSourcedAggregateRoot
{
    /**
     * @param UuidInterface $uuid
     * @param int $number
     * @return Area
     * @throws \App\Domain\Shared\Exception\DateTimeException
     */
    public static function create(
        UuidInterface $uuid,
        int $number
    ): self {
        $natural = Natural::fromInteger($number);

        $area = new self();
        $areaCalculated = TrapezoidalRule::calculateArea($natural);
        $area->apply(new AreaWasCalculated($uuid, $natural, $areaCalculated, DateTime::now()));

        return $area;
    }

    /**
     * @param AreaWasCalculated $event
     */
    protected function applyAreaWasCalculated(AreaWasCalculated $event): void
    {
        $this->uuid = $event->uuid;
        $this->setNatural($event->natural);
        $this->setArea($event->area);
        $this->setCreatedAt($event->createdAt);
    }

    /**
     * @param WeatherWasPronosticated $event
     */
    protected function applyWeatherWasCalculated(WeatherWasPronosticated $event): void
    {
        $this->setWeather($event->weather);
        $this->setUpdatedAt($event->updatedAt);
    }

    private function setNatural(Natural $natural): void
    {
        $this->natural = $natural;
    }

    private function setArea(float $area): void
    {
        $this->area = $area;
    }

    private function setWeather(Weather $weather): void
    {
        $this->weather = $weather;
    }

    private function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    private function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function createdAt(): string
    {
        return $this->createdAt->toString();
    }

    public function updatedAt(): ?string
    {
        return isset($this->updatedAt) ? $this->updatedAt->toString() : null;
    }

    public function natural(): int
    {
        return $this->natural->toInteger();
    }

    public function area(): float
    {
        return $this->area;
    }

    public function weather(): array
    {
        return $this->weather;
    }

    public function uuid(): string
    {
        return $this->uuid->toString();
    }

    public function getAggregateRootId(): string
    {
        return $this->uuid->toString();
    }

    /** @var UuidInterface */
    private $uuid;

    /** @var Natural */
    private $natural;

    /** @var float */
    private $area;

    /** @var array */
    private $weather;

    /** @var DateTime */
    private $createdAt;

    /** @var DateTime|null */
    private $updatedAt;
}
