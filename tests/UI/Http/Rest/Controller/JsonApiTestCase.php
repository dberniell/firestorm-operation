<?php

declare(strict_types=1);

namespace App\Tests\UI\Http\Rest\Controller;

use App\Application\Command\Area\CalculateArea\CalculateAreaCommand;
use League\Tactician\CommandBus;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class JsonApiTestCase extends WebTestCase
{
    public const DEFAULT_NATURAL = 6;

    /**
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    protected function createArea(int $natural = self::DEFAULT_NATURAL):
    int
    {
        $this->areaUuid = Uuid::uuid4();

        $signUp = new CalculateAreaCommand(
            $this->areaUuid->toString(),
            $natural,
        );

        /** @var CommandBus $commandBus */
        $commandBus = $this->cli->getContainer()->get('tactician.commandbus.command');

        $commandBus->handle($signUp);

        return $natural;
    }

    protected function post(string $uri, array $params)
    {
        $this->cli->request(
            'POST',
            $uri,
            [],
            [],
            $this->headers(),
            (string) json_encode($params)
        );
    }

    protected function get(string $uri, array $parameters = [])
    {
        $this->cli->request(
            'GET',
            $uri,
            $parameters,
            [],
            $this->headers()
        );
    }

    protected function logout(): void
    {
        $this->token = null;
    }

    private function headers(): array
    {
        $headers = [
            'CONTENT_TYPE' => 'application/json',
        ];

        return $headers;
    }

    protected function setUp(): void
    {
        $this->cli = static::createClient();
    }

    protected function tearDown(): void
    {
        $this->cli = null;
        $this->token = null;
        $this->areaUuid = null;
    }

    /** @var Client|KernelBrowser|null */
    protected $cli;

    /** @var UuidInterface|null */
    protected $areaUuid;
}
