<?php

declare(strict_types=1);

namespace App\Tests\UI\Http\Rest\Controller\Area;

use App\Tests\Infrastructure\Share\Event\EventCollectorListener;
use App\Tests\UI\Http\Rest\Controller\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetAreaByIdControllerTest extends JsonApiTestCase
{
    /**
     * @test
     *
     * @group e2e
     *
     * @throws \Assert\AssertionFailedException
     */
    public function invalid_input_parameters_should_return_400_status_code(): void
    {
        $this->createArea();

        $this->post('/api/getAreaById', ['natural' => $this->areaUuid]);

        self::assertSame(Response::HTTP_BAD_REQUEST, $this->cli->getResponse()->getStatusCode());

        /** @var EventCollectorListener $eventCollector */
        $eventCollector = $this->cli->getContainer()->get(EventCollectorListener::class);

        $events = $eventCollector->popEvents();

        self::assertCount(1, $events);
    }

    /**
     * @test
     *
     * @group e2e
     *
     * @throws \Assert\AssertionFailedException
     */
    public function valid_input_parameters_should_return_404_status_code_when_not_exist(): void
    {
        $this->createArea();

        $this->post('/api/getAreaById', ['uuid' => 'ee575be8-2bfa-4adf-8d16-e903c13b5cf8']);

        self::assertSame(Response::HTTP_NOT_FOUND, $this->cli->getResponse()->getStatusCode());

        /** @var EventCollectorListener $eventCollector */
        $eventCollector = $this->cli->getContainer()->get(EventCollectorListener::class);

        $events = $eventCollector->popEvents();

        self::assertCount(1, $events);
    }

    /**
     * @test
     *
     * @group e2e
     *
     * @throws \Assert\AssertionFailedException
     */
    public function valid_input_parameters_should_return_200_status_code_when_exist(): void
    {
        $this->createArea();

        $this->post('/api/getAreaById', ['uuid' => $this->areaUuid->toString()]);

        self::assertSame(Response::HTTP_OK, $this->cli->getResponse()->getStatusCode());

        /** @var EventCollectorListener $eventCollector */
        $eventCollector = $this->cli->getContainer()->get(EventCollectorListener::class);

        $events = $eventCollector->popEvents();

        self::assertCount(1, $events);
    }
}
