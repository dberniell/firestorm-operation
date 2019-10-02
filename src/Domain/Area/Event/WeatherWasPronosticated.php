<?php

declare(strict_types=1);

namespace App\Domain\Area\Event;

use App\Domain\Shared\ValueObject\DateTime;
use App\Domain\Area\ValueObject\Weather;
use Assert\Assertion;
use Broadway\Serializer\Serializable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class WeatherWasPronosticated implements Serializable
{
    /**
     * @param array $data
     * @return WeatherWasPronosticated
     * @throws \App\Domain\Shared\Exception\DateTimeException
     */
    public static function deserialize(array $data): self
    {
        Assertion::keyExists($data, 'uuid');
        Assertion::keyExists($data, 'weather');

        return new self(
            Uuid::fromString($data['uuid']),
            Weather::fromArray($data['weather']),
            DateTime::fromString($data['updated_at'])
        );
    }

    public function serialize(): array
    {
        return [
            'uuid'    => $this->uuid->toString(),
            'weather' => $this->weather->toArray(),
            'updated_at' => $this->updatedAt->toString(),
        ];
    }

    public function __construct(UuidInterface $uuid, Weather $weather, DateTime $updatedAt)
    {
        $this->uuid = $uuid;
        $this->weather = $weather;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @var \Ramsey\Uuid\UuidInterface
     */
    public $uuid;

    /**
     * @var Weather
     */
    public $weather;

    /**
     * @var DateTime
     */
    public $updatedAt;
}
