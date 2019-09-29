<?php

declare(strict_types=1);

namespace App\Tests\Domain\Area\Event;

use App\Domain\Area\Event\AreaWasCalculated;
use App\Domain\Shared\ValueObject\DateTime;
use App\Domain\Shared\ValueObject\Natural;
use PHPUnit\Framework\TestCase;

class AreaWasCalculatedTest extends TestCase
{
    /**
     * @test
     *
     * @group unit
     *
     * @throws \Assert\AssertionFailedException
     */
    public function event_should_be_deserializable(): void
    {
        $event = AreaWasCalculated::deserialize([
            'uuid'  => 'eb62dfdc-2086-11e8-b467-0ed5f89f718b',
            'natural' => 6,
            'area' => 6.6666,
            'created_at' => DateTime::now()->toString()
        ]);

        self::assertSame('eb62dfdc-2086-11e8-b467-0ed5f89f718b', $event->uuid->toString());
        self::assertInstanceOf(Natural::class, $event->natural);
    }

    /**
     * @test
     *
     * @group unit
     *
     * @throws \Assert\AssertionFailedException
     */
    public function event_shoud_be_serializable(): void
    {
        $event = AreaWasCalculated::deserialize([
            'uuid'  => 'eb62dfdc-2086-11e8-b467-0ed5f89f718b',
            'natural' => 6,
            'area' => 6.6666,
            'created_at' => DateTime::now()->toString()
        ]);

        $serialized = $event->serialize();

        self::assertArrayHasKey('uuid', $serialized);
        self::assertArrayHasKey('natural', $serialized);
        self::assertArrayHasKey('area', $serialized);
    }

    /**
     * @test
     *
     * @group unit
     *
     * @throws \Assert\AssertionFailedException
     */
    public function event_should_fail_when_deserialize_with_incorrect_data(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        AreaWasCalculated::deserialize([
            'notAnUuid'  => 'eb62dfdc-2086-11e8-b467-0ed5f89f718b',
            'notANatural' => 6,
            'notAFloat' => '6.6666',
            'created_at' => DateTime::now()->toString()
        ]);
    }
}
