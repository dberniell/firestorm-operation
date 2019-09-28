<?php

declare(strict_types=1);

namespace App\Tests\Application\Command\Area\CalculateArea;

use App\Application\Command\Area\CalculateArea\CalculateAreaCommand;
use App\Domain\Area\Event\AreaWasCalculated;
use App\Tests\Application\ApplicationTestCase;
use App\Tests\Infrastructure\Share\Event\EventCollectorListener;
use Broadway\Domain\DomainMessage;
use Ramsey\Uuid\Uuid;

class CalculateAreaHandlerTest extends ApplicationTestCase
{
    /**
     * @test
     *
     * @group integration
     *
     * @throws \Exception
     * @throws \Assert\AssertionFailedException
     */
    public function calculate_area_command_should_fire_event(): void
    {
        $command = new CalculateAreaCommand($uuid = Uuid::uuid4()->toString(), 6);

        $this
            ->handle($command);

        $natural = 6;

        /** @var EventCollectorListener $eventCollector */
        $eventCollector = $this->service(EventCollectorListener::class);

        /** @var DomainMessage[] $events */
        $events = $eventCollector->popEvents();

        self::assertCount(2, $events);

        /** @var AreaWasCalculated $areaWasCalculated */
        $areaWasCalculated = $events[1]->getPayload();

        self::assertInstanceOf(AreaWasCalculated::class, $areaWasCalculated);
        self::assertSame($natural, $areaWasCalculated->natural->toInteger());
    }
}
