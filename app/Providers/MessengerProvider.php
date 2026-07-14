<?php

namespace App\Providers;

use Illuminate\Database\DatabaseManager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\DatabasePresenceVerifier;
use Lifecole\Event\Domain\Bus\Command\CommandBus;
use Lifecole\Event\Domain\Bus\Event\DomainEventPublisher;
use Lifecole\Event\Domain\Bus\Event\Event;
use Lifecole\Event\Domain\Bus\Event\EventBus;
use Lifecole\Event\Domain\Bus\Query\QueryBus;
use Lifecole\Event\Infrastructure\Messenger\Command\SymfonyCommandBus;
use Lifecole\Event\Infrastructure\Messenger\Event\SymfonyDomainEventPublisher;
use Lifecole\Event\Infrastructure\Messenger\Event\SymfonyEventBus;
use Lifecole\Event\Infrastructure\Messenger\Query\SymfonyQueryBus;
use Lifecole\Shared\Infrastructure\Bus\Messenger\LifecoleHandlersLocator;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\Messenger\Bridge\Doctrine\Transport\DoctrineTransportFactory;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Middleware\AddBusNameStampMiddleware;
use Symfony\Component\Messenger\Middleware\DispatchAfterCurrentBusMiddleware;
use Symfony\Component\Messenger\Middleware\FailedMessageProcessingMiddleware;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Middleware\RejectRedeliveredMessageMiddleware;
use Symfony\Component\Messenger\Middleware\SendMessageMiddleware;
use Symfony\Component\Messenger\Middleware\TraceableMiddleware;
use Symfony\Component\Messenger\Transport\Sender\SendersLocator;
use Symfony\Component\Messenger\Transport\Serialization\PhpSerializer;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Stopwatch\Stopwatch;

class MessengerProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Definimos este servicio con la clase de Illuminate ya que la de Doctrine falla
        $this->app->singleton('validation.presence', function ($app) {
            return new DatabasePresenceVerifier($app->get(DatabaseManager::class));
        });
        //

        $this->app->bind(QueryBus::class, function ($app) {
            return new SymfonyQueryBus($app->get('query.bus'));
        });

        $this->app->bind(CommandBus::class, function ($app) {
            return new SymfonyCommandBus($app->get('command.bus'));
        });

        $this->app->bind(EventBus::class, function ($app) {
            return new SymfonyEventBus($app->get('event.bus'));
        });

        $this->app->bind(MessageBusInterface::class, MessageBus::class);

        $this->app->bind(DomainEventPublisher::class, function () {
            return new SymfonyDomainEventPublisher();
        });

        $this->app->bind('query.bus.middleware.traceable', function () {
            return new TraceableMiddleware(new Stopwatch(), 'query.bus');
        });

        $this->app->bind('query.bus.middleware.add_bus_name_stamp_middleware', function () {
            return new AddBusNameStampMiddleware('query.bus');
        });

        $this->app->bind('command.bus.middleware.traceable', function () {
            return new TraceableMiddleware(new Stopwatch(), 'command.bus');
        });

        $this->app->bind('command.bus.middleware.add_bus_name_stamp_middleware', function () {
            return new AddBusNameStampMiddleware('command.bus');
        });

        $this->app->bind('event.bus.middleware.traceable', function () {
            return new TraceableMiddleware(new Stopwatch(), 'event.bus');
        });

        $this->app->bind('event.bus.middleware.add_bus_name_stamp_middleware', function () {
            return new AddBusNameStampMiddleware('event.bus');
        });

        $this->app->bind('messenger.middleware.reject_redelivered_message_middleware', function () {
            return new RejectRedeliveredMessageMiddleware();
        });

        $this->app->bind('messenger.middleware.dispatch_after_current_bus', function () {
            return new DispatchAfterCurrentBusMiddleware();
        });

        $this->app->bind('messenger.middleware.failed_message_processing_middleware', function () {
            return new FailedMessageProcessingMiddleware();
        });

        /*$this->app->bind('messenger.middleware.validation', function() {
            return new ValidationMiddleware();
        });*/

        $this->app->bind('messenger.middleware.send_message', function () {
            return new SendMessageMiddleware(
                new SendersLocator([Event::class => [0 => 'async']], $this->app->get(ContainerInterface::class))
            );
        });

        $this->app->bind('query.bus.middleware.handle_message', function () {
            return new HandleMessageMiddleware(
                new LifecoleHandlersLocator(),
                false
            );
        });

        $this->app->bind('command.bus.middleware.handle_message', function () {
            return new HandleMessageMiddleware(
                new LifecoleHandlersLocator(),
                false
            );
        });

        $this->app->bind('event.bus.middleware.handle_message', function () {
            return new HandleMessageMiddleware(
                new LifecoleHandlersLocator(),
                false
            );
        });

        $this->app->bind(SerializerInterface::class, function () {
            return new PhpSerializer();
        });

        $this->app->bind('async', function () {
            $factory = new DoctrineTransportFactory($this->app->get('registry'));
            return $factory->createTransport('doctrine://default', ['transport_name' => 'async'], $this->app->get(SerializerInterface::class));
        });

        $this->app->bind('query.bus', function () {
            return new \Symfony\Component\Messenger\TraceableMessageBus(new \Symfony\Component\Messenger\MessageBus(new RewindableGenerator(function () {
                yield 0 => $this->app->get('query.bus.middleware.traceable');
                yield 1 => $this->app->get('query.bus.middleware.add_bus_name_stamp_middleware');// ?? ($this->privates['query.bus.middleware.add_bus_name_stamp_middleware'] = new \Symfony\Component\Messenger\Middleware\AddBusNameStampMiddleware('query.bus')));
                yield 2 => $this->app->get('messenger.middleware.reject_redelivered_message_middleware');//] ?? ($this->privates['messenger.middleware.reject_redelivered_message_middleware'] = new \Symfony\Component\Messenger\Middleware\RejectRedeliveredMessageMiddleware()));
                yield 3 => $this->app->get('messenger.middleware.dispatch_after_current_bus');//] ?? ($this->privates['messenger.middleware.dispatch_after_current_bus'] = new \Symfony\Component\Messenger\Middleware\DispatchAfterCurrentBusMiddleware()));
                yield 4 => $this->app->get('messenger.middleware.failed_message_processing_middleware');//] ?? ($this->privates['messenger.middleware.failed_message_processing_middleware'] = new \Symfony\Component\Messenger\Middleware\FailedMessageProcessingMiddleware()));
                //yield 5 => $this->app->get('messenger.middleware.validation');
                yield 5 => $this->app->get('Lifecole\\Event\\Infrastructure\\Messenger\\Middleware\\MessageLoggerMiddleware');
                yield 6 => $this->app->get('Lifecole\\Event\\Infrastructure\\Messenger\\Middleware\\DispatchEvents');
                yield 7 => $this->app->get('messenger.middleware.send_message');
                yield 8 => $this->app->get('query.bus.middleware.handle_message');
            }, 9)));
        });

        $this->app->bind('command.bus', function () {
            return new \Symfony\Component\Messenger\TraceableMessageBus(new \Symfony\Component\Messenger\MessageBus(new RewindableGenerator(function () {
                yield 1 => $this->app->get('command.bus.middleware.traceable');
                yield 2 => $this->app->get('command.bus.middleware.add_bus_name_stamp_middleware');// ?? ($this->privates['query.bus.middleware.add_bus_name_stamp_middleware'] = new \Symfony\Component\Messenger\Middleware\AddBusNameStampMiddleware('query.bus')));
                yield 3 => $this->app->get('messenger.middleware.reject_redelivered_message_middleware');//] ?? ($this->privates['messenger.middleware.reject_redelivered_message_middleware'] = new \Symfony\Component\Messenger\Middleware\RejectRedeliveredMessageMiddleware()));
                yield 4 => $this->app->get('messenger.middleware.dispatch_after_current_bus');//] ?? ($this->privates['messenger.middleware.dispatch_after_current_bus'] = new \Symfony\Component\Messenger\Middleware\DispatchAfterCurrentBusMiddleware()));
                yield 5 => $this->app->get('messenger.middleware.failed_message_processing_middleware');//] ?? ($this->privates['messenger.middleware.failed_message_processing_middleware'] = new \Symfony\Component\Messenger\Middleware\FailedMessageProcessingMiddleware()));
                //yield 5 => $this->app->get('messenger.middleware.validation');
                yield 6 => $this->app->get('Lifecole\\Event\\Infrastructure\\Messenger\\Middleware\\MessageLoggerMiddleware');
                yield 7 => $this->app->get('Lifecole\\Event\\Infrastructure\\Messenger\\Middleware\\DispatchEvents');
                yield 8 => $this->app->get('messenger.middleware.send_message');
                yield 9 => $this->app->get('command.bus.middleware.handle_message');
            }, 10)));
        });

        $this->app->bind('event.bus', function () {
            return new \Symfony\Component\Messenger\TraceableMessageBus(new \Symfony\Component\Messenger\MessageBus(new RewindableGenerator(function () {
                yield 1 => $this->app->get('event.bus.middleware.traceable');
                yield 2 => $this->app->get('event.bus.middleware.add_bus_name_stamp_middleware');// ?? ($this->privates['query.bus.middleware.add_bus_name_stamp_middleware'] = new \Symfony\Component\Messenger\Middleware\AddBusNameStampMiddleware('query.bus')));
                yield 3 => $this->app->get('messenger.middleware.reject_redelivered_message_middleware');//] ?? ($this->privates['messenger.middleware.reject_redelivered_message_middleware'] = new \Symfony\Component\Messenger\Middleware\RejectRedeliveredMessageMiddleware()));
                yield 4 => $this->app->get('messenger.middleware.dispatch_after_current_bus');//] ?? ($this->privates['messenger.middleware.dispatch_after_current_bus'] = new \Symfony\Component\Messenger\Middleware\DispatchAfterCurrentBusMiddleware()));
                yield 5 => $this->app->get('messenger.middleware.failed_message_processing_middleware');//] ?? ($this->privates['messenger.middleware.failed_message_processing_middleware'] = new \Symfony\Component\Messenger\Middleware\FailedMessageProcessingMiddleware()));
                //yield 5 => $this->app->get('messenger.middleware.validation');
                yield 6 => $this->app->get('Lifecole\\Event\\Infrastructure\\Messenger\\Middleware\\MessageLoggerMiddleware');
                yield 7 => $this->app->get('messenger.middleware.send_message');
                yield 8 => $this->app->get('event.bus.middleware.handle_message');
            }, 9)));
        });
    }
}
