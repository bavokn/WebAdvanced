<?php

namespace Laudis\Calculators\Registers;

use Controllers\UserController;
use Controllers\PostController;
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
        // TODO - register routes here
        $app->options('/{routes:.+}', PreflightCorsController::class . ':allowOptions');

        // This is the middleware
        // It will add the Access-Control-Allow-Methods header to every request

        $app->add(function($request, $response, $next) {
            $route = $request->getAttribute("/twitter");

            $methods = [];

            if (!empty($route)) {
                $pattern = $route->getPattern();

                foreach ($this->router->getRoutes() as $route) {
                    if ($pattern === $route->getPattern()) {
                        $methods = array_merge_recursive($methods, $route->getMethods());
                    }
                }
                //Methods holds all of the HTTP Verbs that a particular route handles.
            } else {
                $methods[] = $request->getMethod();
            }

            $response = $next($request, $response);


            return $response->withHeader("Access-Control-Allow-Methods", implode(",", $methods));
        });

        $app->get('/twitter/users',UserController::class . "::listUsers");

        $app->get('/twitter/posts/{id}', PostController::class . "::listPosts");

        # Fallback route because options route now triggers Method Not Allowed 405.
        $app->map(self::FALLBACK_METHODS, '/{routes:.+}', PreflightCorsController::class . ':fallback');
    }
}
