<?php

namespace Laudis\Calculators\Registers;

use Closure;
use Laudis\Calculators\Controllers\PostController;
use Laudis\Calculators\Controllers\PreflightCorsController;
use Laudis\Calculators\Controllers\UserController;
use Laudis\Calculators\Models\PDOPostModel;
use Laudis\Calculators\Models\PDOUserModel;
use Laudis\Calculators\Models\PostModel;
use Laudis\Calculators\Models\UserModel;
use Laudis\Calculators\Strategies\WriteJsonToResponse;
use Locale;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use NumberFormatter;
use PDO;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Rakit\Validation\Validator;
use Slim\Http\Body;
use Slim\Http\Headers;
use Slim\Http\Response;
use function getenv;

/**
 * Class DependencyRegister
 * Registry of various dependencies.
 *
 * @package Laudis\Calculators\Registers
 */
final class DependencyRegister
{
    /**
     * Registers various dependencies to the container.
     *
     * @param ContainerInterface $container
     */
    public function register(ContainerInterface $container): void
    {
        $container['response'] = Closure::fromCallable([$this, 'buildResponse']);
        $container[PreflightCorsController::class] = new PreflightCorsController;
        $container[Validator::class] = Closure::fromCallable([$this, 'buildValidator']);
        $container[WriteJsonToResponse::class] = new WriteJsonToResponse;
        $container[NumberFormatter::class] = Closure::fromCallable([$this, 'buildNumberFormatter']);
        $container['locale'] = Closure::fromCallable([$this, 'buildLocale']);

        // TODO - You have done a great job on this
        $container[UserModel::class] = function (ContainerInterface $container) {
            return new PDOUserModel(
                $container[PDO::class]
            );
        };

        $container[PostModel::class] = function (ContainerInterface $container) {
            return new PDOPostModel(
                $container[PDO::class]
            );
        };

        $container[UserController::class] = function (ContainerInterface $container) {
            return new UserController(
                $container[WriteJsonToResponse::class],
                $container[UserModel::class]
            );
        };
        $container[PostController::class] = function (ContainerInterface $container) {
            return new PostController(
                $container[WriteJsonToResponse::class],
                $container[PostModel::class]
            );
        };
        $container[PDO::class] = function (ContainerInterface $container) {
            $settings = $container["settings"]["PDO"];
            return new PDO($settings['dsn'], $settings['username'], $settings['passwd']);
        };

        $container['logger'] = function (ContainerInterface $container) {
            $logger = $container['settings']['logger'];
            $log = new Logger($logger['name']);
            $handler = new StreamHandler($logger['path'], $logger['level']);
            $handler->setFormatter(new LineFormatter(null, null, true, true));
            $log->pushHandler($handler);
            return $log;
        };
    }

    private function buildLocale(ContainerInterface $container): string
    {
        return Locale::acceptFromHttp(getenv('APP_LOCALE') ?? $container['settings']['locale']);
    }

    /**
     * @param ContainerInterface $container
     * @return NumberFormatter
     */
    private function buildNumberFormatter(ContainerInterface $container): NumberFormatter
    {
        $formatter = NumberFormatter::create($container['locale'] ?? getenv('APP_LOCALE'), NumberFormatter::CURRENCY);
        $formatter->setTextAttribute(NumberFormatter::FRACTION_DIGITS, 2);
        return $formatter;
    }

    /**
     * @return Validator
     */
    private function buildValidator(): Validator
    {
        return new Validator([
            'required' => 'Gelieve dit veld in te vullen.',
            'numeric' => 'Dit veld moet een getal zijn.',
        ]);
    }

    /**
     * @return ResponseInterface
     */
    private function buildResponse(): ResponseInterface
    {
        return new Response(
            200,
            new Headers([
                'Content-Type' => 'application/json;charset=utf-8',
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Headers' => 'X-Requested-With, Content-Type, Accept, Origin, Authorization',
                'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, PATCH, OPTIONS'
            ]),
            new Body(fopen('php://temp', 'rb+'))
        );
    }
}
