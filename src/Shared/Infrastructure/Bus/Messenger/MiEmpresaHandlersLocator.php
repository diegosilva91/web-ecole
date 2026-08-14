<?php

namespace Mi-empresa\Shared\Infrastructure\Bus\Messenger;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Handler\HandlerDescriptor;
use Symfony\Component\Messenger\Handler\HandlersLocatorInterface;

class Mi-empresaHandlersLocator implements HandlersLocatorInterface
{
    private const HANDLER_PREFIX = 'Handler';

    /**
     * {@inheritdoc}
     */
    public function getHandlers(Envelope $envelope): iterable
    {
        foreach (self::listTypes($envelope) as $requestName) {
            $handlerClass = $this->getHandlerClass($requestName);
            yield new HandlerDescriptor(function($message) use ($handlerClass) {
                return app()->make($handlerClass)($message);
            });
        }
    }

    /**
     * @internal
     */
    public static function listTypes(Envelope $envelope): array
    {
        $class = \get_class($envelope->getMessage());

        return [$class => $class]
            + class_parents($class)
            + class_implements($class)
            + ['*' => '*'];
    }

    private function getHandlerClass(string $requestName): string
    {
        return $requestName . self::HANDLER_PREFIX;
    }
}
