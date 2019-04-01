<?php

namespace Laudis\Calculators\Registers;

use Closure;
use Laudis\Calculators\Contracts\ExceptionHandlerInterface;
use Laudis\Calculators\Contracts\FinalExceptionHandler;
use Laudis\Calculators\Handlers\DebugExceptionHandler;
use Laudis\Calculators\Handlers\ProductionExceptionHandler;
use Laudis\Calculators\Handlers\ThrowableHandler;
use Laudis\Calculators\Handlers\ValidationExceptionHandler;
use Laudis\Calculators\Presenters\ValidationPresenter;
use Laudis\Calculators\Strategies\WriteJsonToResponse;
use Psr\Container\ContainerInterface;

/**
 * Class ExceptionHandlerRegister
 * Registers all exception handling.
 *
 * @package Laudis\Calculators\Registers
 */
final class ExceptionHandlerRegister
{
    /**
     * Registers all the exception handling to the container.
     *
     * @param ContainerInterface $container
     */
    public function register(ContainerInterface $container): void
    {
        $this->registerFrameworkHandlers($container);
        $container[FinalExceptionHandler::class] = Closure::fromCallable([$this, 'finalExceptionHandler']);
        $container['exceptionHandlers'] = Closure::fromCallable([$this, 'exceptionHandlers']);
    }

    /**
     * Registers and overrides the basic error handlers from the slim framework.
     *
     * @param ContainerInterface $container
     */
    private function registerFrameworkHandlers(ContainerInterface $container): void
    {
        $handler = function (ContainerInterface $container) {
            return new ThrowableHandler($container[FinalExceptionHandler::class], $container['exceptionHandlers']);
        };

        $container['errorHandler'] = $handler;
        $container['phpErrorHandler'] = $handler;
    }

    /**
     * Registers the final exceptionhandler.
     *
     * @param ContainerInterface $container
     * @return ExceptionHandlerInterface
     */
    private function finalExceptionHandler(ContainerInterface $container): ExceptionHandlerInterface
    {
        if ((bool) $container['settings']['debug']) {
            return new DebugExceptionHandler($container[WriteJsonToResponse::class]);
        }
        return new ProductionExceptionHandler($container[WriteJsonToResponse::class]);
    }

    /**
     * Registers all other exception handlers.
     *
     * @param ContainerInterface $container
     * @return array
     */
    private function exceptionHandlers(ContainerInterface $container): array
    {
        $tbr = [
            new ValidationExceptionHandler($container[WriteJsonToResponse::class], new ValidationPresenter),
        ];

        return $tbr;
    }
}
