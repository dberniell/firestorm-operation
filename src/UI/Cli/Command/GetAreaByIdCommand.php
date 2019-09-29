<?php

declare(strict_types=1);

namespace App\UI\Cli\Command;

use App\Application\Query\Area\GetAreaById\GetAreaByIdQuery;
use App\Application\Query\Item;
use App\UI\Http\Rest\Response\JsonApiFormatter;
use League\Tactician\CommandBus;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetAreaByIdCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('app:get-area-by-id')
            ->setDescription('Given a uuid get area.')
            ->addArgument('uuid', InputArgument::REQUIRED, 'Area Uuid')
        ;
    }

    /**
     * @throws \Exception
     * @throws \Assert\AssertionFailedException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var string $uuid */
        $uuid = $input->getArgument('uuid');

        $command = new GetAreaByIdQuery($uuid);

        /** @var Item $resource */
        $resource = $this->queryBus->handle($command);

        $output->writeln(json_encode($this->formatter->one($resource, [$this, 'formatResponse'])));
    }

    public function formatResponse($key)
    {
        return in_array($key, ['area', 'weather']);
    }

    public function __construct(CommandBus $queryBus, JsonApiFormatter $formatter)
    {
        parent::__construct();
        $this->queryBus = $queryBus;
        $this->formatter = $formatter;
    }

    /**
     * @var CommandBus
     */
    private $queryBus;

    /**
     * @var JsonApiFormatter
     */
    private $formatter;
}
