<?php

declare(strict_types=1);

namespace App\Domain\Area\Event;

use App\Domain\Shared\Exception\DateTimeException;
use App\Domain\Shared\ValueObject\DateTime;
use App\Domain\Shared\ValueObject\Natural;
use Assert\Assertion;
use Broadway\Serializer\Serializable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class AreaWasCalculated implements Serializable
{
    /**
     * @param array $data
     * @return AreaWasCalculated
     * @throws DateTimeException
     */
    public static function deserialize(array $data): self
    {
        Assertion::keyExists($data, 'uuid');
        Assertion::keyExists($data, 'natural');
        Assertion::keyExists($data, 'area');

        return new self(
            Uuid::fromString($data['uuid']),
            Natural::fromInteger($data['natural']),
            $data['area'],
            DateTime::fromString($data['created_at'])
        );
    }

    public function serialize(): array
    {
        return [
            'uuid'    => $this->uuid->toString(),
            'natural'    => $this->natural->toInteger(),
            'area'    => $this->area,
            'created_at' => $this->createdAt->toString(),
        ];
    }

    public function __construct(UuidInterface $uuid, Natural $natural, float $area, DateTime $createdAt)
    {
        $this->uuid = $uuid;
        $this->area = $area;
        $this->natural = $natural;
        $this->createdAt = $createdAt;
    }

    /**
     * @var UuidInterface
     */
    public $uuid;

    /**
     * @var Natural
     */
    public $natural;

    /**
     * @var float
     */
    public $area;

    /**
     * @var DateTime
     */
    public $createdAt;
}
