<?php

namespace Laudis\Calculators\Registers;

use Laudis\Calculators\Controllers\UserController;
use Laudis\Calculators\Controllers\PostController;
use Laudis\Calculators\Controllers\PreflightCorsController;
use Slim\App;

/**
 * Class RouteRegister
 * Registers all routes of the application.
 *
 * @package Laudis\Calculators\Registers
 */
final class RouteRegister
{
    private const FALLBACK_METHODS = ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'];

    public function register(App $app): void
    {
        $app->options('/{routes:.+}', PreflightCorsController::class . ':allowOptions');

        $app->get('/twitter/users',UserController::class . ":listUsers");

        $app->get('/twitter/posts/{id}', PostController::class . ":listPostsByID");

        $app->get('/twitter/posts', PostController::class . ":listAllPosts");

        $app->delete("/twitter/delete/{id}", UserController::class . ":deleteUser");

        # Fallback route because options route now triggers Method Not Allowed 405.
        $app->map(self::FALLBACK_METHODS, '/{routes:.+}', PreflightCorsController::class . ':fallback');
    }
}
