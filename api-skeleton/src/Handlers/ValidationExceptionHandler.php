<?php

namespace Laudis\Calculators\Handlers;

use Laudis\Calculators\Contracts\ResponseWriterInterface;
use Laudis\Calculators\Exceptions\ValidationException;
use Laudis\Calculators\Presenters\ValidationPresenter;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Class ValidationExceptionHandler
 * Handles all validation exceptions.
 *
 * @package Laudis\Calculators\Handlers
 */
final class ValidationExceptionHandler extends BaseHandler
{
    /** @var ValidationPresenter */
    private $presenter;

    public function __construct(ResponseWriterInterface $jsonToResponse, ValidationPresenter $presenter)
    {
        parent::__construct($jsonToResponse);
        $this->presenter = $presenter;
    }

    /**
     * Handles the validation exception.
     *
     * @param ResponseInterface $response
     * @param Throwable $exception
     * @return ResponseInterface|null
     */
    public function handleException(ResponseInterface $response, Throwable $exception): ?ResponseInterface
    {
        if ($exception instanceof ValidationException) {
            return $this->writeJson($response, [
                'message' => 'De gegeven informatie is niet correct.',
                'data' => $this->presenter->present($exception->getValidation()),
            ], 422);
        }
        return null;
    }
}
