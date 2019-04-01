<?php

namespace Laudis\Calculators\Registers;

use Slim\App;

/**
 * Class MainRegister
 * The main register of the application.
 *
 * @package Laudis\Calculators\Registers
 */
final class MainRegister
{
    /** @var DependencyRegister */
    private $dependencyRegister;
    /** @var RouteRegister */
    private $routeRegister;
    /** @var ExceptionHandlerRegister */
    private $exceptionHandlerRegister;

    public function __construct(
        DependencyRegister $dependencyRegister,
        RouteRegister $routeRegister,
        ExceptionHandlerRegister $exceptionHandlerRegister
    ) {
        $this->dependencyRegister = $dependencyRegister;
        $this->routeRegister = $routeRegister;
        $this->exceptionHandlerRegister = $exceptionHandlerRegister;
    }

    /**
     * Initiates the main register.
     *
     * @return MainRegister
     */
    public static function make(): MainRegister
    {
        return new self(
            new DependencyRegister,
            new RouteRegister,
            new ExceptionHandlerRegister
        );
    }

    public function register(App $app): void
    {
        $this->dependencyRegister->register($app->getContainer());
        $this->routeRegister->register($app);
        $this->exceptionHandlerRegister->register($app->getContainer());
    }
}
