<?php

declare(strict_types=1);

namespace App\Tests\UI\Cli\Command;

use App\Application\Query\Area\GetAreaById\GetAreaByIdQuery;
use App\Application\Query\Item;
use App\Infrastructure\Area\Query\Projections\AreaView;
use App\Tests\UI\Cli\AbstractConsoleTestCase;
use App\UI\Cli\Command\CalculateAreaCommand;
use League\Tactician\CommandBus;
use Ramsey\Uuid\Uuid;

class CalculateAreaCommandTest extends AbstractConsoleTestCase
{
    /**
     * @test
     *
     * @group unit
     *
     * @throws \Exception
     * @throws \Assert\AssertionFailedException
     */
    public function command_integration_with_bus_success(): void
    {
        $uuid = Uuid::uuid4()->toString();
        $natural = '6';

        /** @var CommandBus $commandBus */
        $commandBus = $this->service('tactician.commandbus.command');
        $commandTester = $this->app($command = new CalculateAreaCommand($commandBus), 'app:calculate-area');

        $commandTester->execute([
            'command'  => $command->getName(),
            'uuid'     => $uuid,
            'naturalNumber'    => $natural,
        ]);

        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('"natural":6', $output);

        /** @var Item $item */
        $item = $this->ask(new GetAreaByIdQuery($uuid));
        /** @var AreaView $areaRead */
        $areaRead = $item->readModel;

        self::assertInstanceOf(Item::class, $item);
        self::assertInstanceOf(AreaView::class, $areaRead);
        self::assertSame((int) $natural, $areaRead->natural());
    }
}
