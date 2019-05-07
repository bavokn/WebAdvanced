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
        //works
        $app->get('/twitter/users',UserController::class . ":listUsers");
        //this returns aanslagjaar : 2019 ?!?!
        $app->get('/twitter/posts/{id}', PostController::class . ":listPostsByID");
        //works
        $app->get('/twitter/posts', PostController::class . ":listAllPosts");
        //needs to run twice to delete posts and users ?
        $app->delete("/twitter/deleteUser/{id}", UserController::class . ":deleteUser");
        //works
        $app->post('/twitter/addUser',UserController::class . ":addUser");
        //works
        $app->post("/twitter/addPost",PostController::class . ":addPost");
        //works
        $app->delete("/twitter/deletePost/{postID}", PostController::class . ":deletePost");
        //works
        $app->put("/twitter/updateUser"    , UserController::class . ":updateUser");

        # Fallback route because options route now triggers Method Not Allowed 405.
        $app->map(self::FALLBACK_METHODS, '/{routes:.+}', PreflightCorsController::class . ':fallback');
    }
}
