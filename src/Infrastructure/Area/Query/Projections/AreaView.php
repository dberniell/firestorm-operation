<?php

declare(strict_types=1);

namespace App\Infrastructure\Area\Query\Projections;

use App\Domain\Area\ValueObject\Weather;
use App\Domain\Shared\ValueObject\DateTime;
use App\Domain\Shared\ValueObject\Natural;
use Broadway\ReadModel\SerializableReadModel;
use Broadway\Serializer\Serializable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class AreaView implements SerializableReadModel
{
    /**
     * @throws \App\Domain\Shared\Exception\DateTimeException
     * @throws \Assert\AssertionFailedException
     */
    public static function fromSerializable(Serializable $event): self
    {
        return self::deserialize($event->serialize());
    }

    /**
     * @return AreaView
     *@throws \Assert\AssertionFailedException
     *
     * @throws \App\Domain\Shared\Exception\DateTimeException
     */
    public static function deserialize(array $data): self
    {
        $instance = new self();

        $instance->area = isset($data['area']) ? $data['area'] : null;
        $instance->weather = isset($data['weather']) ? json_decode($data['weather'], true) : null;

        $instance->createdAt = DateTime::fromString($data['created_at']);
        $instance->updatedAt = isset($data['updated_at']) ? DateTime::fromString($data['updated_at']) : null;

        return $instance;
    }

    public function serialize(): array
    {
        return [
            'area' => $this->area(),
            'weather' => $this->weather()
        ];
    }

    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function area(): float
    {
        return (float) $this->area;
    }

    public function natural(): int
    {
        return $this->natural->toInteger();
    }

    public function weatherPronosticated(Weather $weather)
    {
        $this->weather = $weather;
    }

    public function areaCalculated(float $area)
    {
        $this->area = $area;
    }

    public function weather(): string
    {
        return $this->weather->toString();
    }

    public function changeUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getId(): string
    {
        return $this->uuid->toString();
    }

    /** @var UuidInterface */
    private $uuid;

    /** @var Natural */
    private $natural;

    /** @var float */
    private $area;

    /** @var Weather */
    private $weather;

    /** @var DateTime */
    private $createdAt;

    /** @var DateTime */
    private $updatedAt;
}
