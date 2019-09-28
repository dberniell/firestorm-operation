<?php

declare(strict_types=1);

namespace App\UI\Cli\Command;

use App\Application\Command\Area\CalculateArea\CalculateAreaCommand as CalculateArea;
use League\Tactician\CommandBus;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CalculateAreaCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('app:calculate-area')
            ->setDescription('Given a uuid and natural number, calculates new area.')
            ->addArgument('naturalNumber', InputArgument::REQUIRED, 'Natural number')
            ->addArgument('uuid', InputArgument::OPTIONAL, 'Area Uuid')
        ;
    }

    /**
     * @throws \Exception
     * @throws \Assert\AssertionFailedException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Uuid $uuid */
        $uuid = $input->getArgument('uuid') ?: Uuid::uuid4()->toString();
        /** @var int $naturalNumber */
        $naturalNumber = (int) $input->getArgument('naturalNumber');

        $command = new CalculateArea($uuid, $naturalNumber);

        $this->commandBus->handle($command);

        $response = [
            "uuid" => $uuid,
            "natural" => $naturalNumber
        ];
        $output->writeln(json_encode($response));
    }

    public function __construct(CommandBus $commandBus)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
    }

    /**
     * @var CommandBus
     */
    private $commandBus;
}
