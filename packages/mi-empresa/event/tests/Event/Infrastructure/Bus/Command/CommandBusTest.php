<?php

declare(strict_types=1);

namespace Mi-empresa\Tests\Event\Infrastructure\Bus\Command;

use Mi-empresa\Event\Domain\Bus\Command\CommandNotRegisteredError;
use Mi-empresa\Event\Infrastructure\Messenger\Command\SymfonyCommandBus;
use Mi-empresa\Tests\Event\Application\Command\OnlyCommand;
use Mi-empresa\Tests\Event\Application\Command\SumCommand;
use Mi-empresa\Tests\Event\Application\Command\SumCommandHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

class CommandBusTest extends TestCase
{
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    public function testCommandBus()
    {
        $handler = new SumCommandHandler();

        $messageBusInterface = new MessageBus([
            new HandleMessageMiddleware(new HandlersLocator([
                SumCommand::class => [$handler],
            ])),
        ]);
        $CommandBus = new SymfonyCommandBus($messageBusInterface);

        $responseSum = $CommandBus->dispatch(new SumCommand(...[1, 2, 3]));

        $this->assertEquals($responseSum, null);
    }

    public function testCommandBusNoHandler()
    {
        $this->expectException(CommandNotRegisteredError::class);

        $messageBusInterface = new MessageBus([
            new HandleMessageMiddleware(new HandlersLocator([
                SumCommand::class => [new SumCommandHandler()],
            ])),
        ]);

        $commandBus = new SymfonyCommandBus($messageBusInterface);
        $commandBus->dispatch(new OnlyCommand());
    }
}
