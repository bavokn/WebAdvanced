<?php

namespace Laudis\Calculators\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class PreflightCorsController
 * Handles all preflight requests.
 *
 * @package Laudis\Calculators\Controllers
 */
final class PreflightCorsController extends BaseController
{
    /**
     * Allow all option requests in the case of a preflight.
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function allowOptions(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->writeToResponse($response, [
            'message' => 'Option OK.'
        ]);
    }

    /**
     * Falls back to catch all other routes so they don't trigger a 405 status.
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function fallback(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->writeToResponse($response, [
            'message' => 'Resource not found.'
        ], 404);
    }
}
