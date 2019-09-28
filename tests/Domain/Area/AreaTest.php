<?php

namespace App\Tests\Domain\Area;

use App\Domain\Area\Event\AreaWasCalculated;
use App\Domain\Area\Area;
use Broadway\Domain\DomainMessage;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class AreaTest extends TestCase
{
    private $isUniqueException = false;

    /**
     * @test
     *
     * @group unit
     *
     * @throws \Exception
     * @throws \Assert\AssertionFailedException
     */
    public function given_a_valid_natural_it_should_create_an_area_instance(): void
    {
        $natural = 6;

        $area = Area::create(
            Uuid::uuid4(),
            $natural
        );

        self::assertSame($natural, $area->natural());
        self::assertNotNull($area->uuid());

        $events = $area->getUncommittedEvents();

        self::assertCount(1, $events->getIterator(), 'Only one event should be in the buffer');

        /** @var DomainMessage $event */
        $event = $events->getIterator()->current();

        self::assertInstanceOf(AreaWasCalculated::class, $event->getPayload(), 'First event should be AreaWasCalculated');
    }
}
