<?php

namespace Laudis\Calculators\Handlers;

use Laudis\Calculators\Contracts\ExceptionHandlerInterface;
use Laudis\Calculators\Contracts\FinalExceptionHandler;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;
use function array_pop;

/**
 * Class ThrowableHandler
 * Throwable handler overriding the default behaviour of the slim framework.
 *
 * @package Laudis\Calculators\Handlers
 */
final class ThrowableHandler
{
    /** @var ExceptionHandlerInterface[] */
    private $handlers;

    /**
     * ThrowableHandler constructor.
     *
     * @param FinalExceptionHandler $finalHandler
     * @param ExceptionHandlerInterface[] $handlers
     */
    public function __construct(FinalExceptionHandler $finalHandler, array $handlers)
    {
        $this->handlers = array_merge([$finalHandler], $handlers);
    }

    /**
     * Handles the exception and returns the appropriate response.
     *
     * @param Request $request
     * @param Response $response
     * @param Throwable $exception
     * @return Response
     */
    public function __invoke(Request $request, Response $response, Throwable $exception): Response
    {
        do {
            $mutatedResponse = array_pop($this->handlers)->handleException($response, $exception);
        } while ($mutatedResponse === null);

        return $mutatedResponse;
    }
}
