<?php

declare(strict_types=1);

namespace App\Tests\Application\Query\User\FindByEmail;

use App\Application\Command\Area\CalculateArea\CalculateAreaCommand;
use App\Application\Query\Item;
use App\Application\Query\Area\GetAreaById\GetAreaByIdQuery;
use App\Infrastructure\Area\Query\Projections\AreaView;
use App\Tests\Application\ApplicationTestCase;
use Ramsey\Uuid\Uuid;

class GetAreaByIdHandlerTest extends ApplicationTestCase
{
    /**
     * @test
     *
     * @group integration
     *
     * @throws \Exception
     * @throws \Assert\AssertionFailedException
     */
    public function query_command_integration(): void
    {
        $uuid = $this->createUserRead();

        $this->fireTerminateEvent();

        /** @var Item $item */
        $item = $this->ask(new GetAreaByIdQuery($uuid));
        /** @var AreaView $areaRead */
        $areaRead = $item->readModel;

        self::assertInstanceOf(Item::class, $item);
        self::assertInstanceOf(AreaView::class, $areaRead);
        self::assertSame($uuid, $areaRead->uuid());
    }

    /**
     * @throws \Exception
     * @throws \Assert\AssertionFailedException
     */
    private function createUserRead(): string
    {
        $uuid = Uuid::uuid4()->toString();
        $natural = 6;

        $this->handle(new CalculateAreaCommand($uuid, $natural));

        return $uuid;
    }
}
