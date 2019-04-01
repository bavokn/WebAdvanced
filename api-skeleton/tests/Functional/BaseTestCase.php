<?php

namespace Laudis\Calculators\Tests\Functional;

use Dotenv\Dotenv;
use Laudis\Calculators\Registers\MainRegister;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\App;
use Slim\Http\Environment;
use Slim\Http\Request;


/**
 * Class BaseTestCase
 * @package Tests\Functional
 */
abstract class BaseTestCase extends TestCase
{
    /** @var ContainerInterface */
    private $container;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        Dotenv::create(__DIR__ . './../../')->load();
    }

    /**
     * Process the application given a request method and URI
     *
     * @param string $requestMethod the request method (e.g. GET, POST, etc.)
     * @param string $requestUri the request URI
     * @param array|object|null $requestData the request data
     * @return ResponseInterface
     * @throws \Slim\Exception\MethodNotAllowedException
     * @throws \Slim\Exception\NotFoundException
     */
    protected function runApp(string $requestMethod, string $requestUri, array $requestData = null): ResponseInterface
    {
        $environment = Environment::mock([
            'REQUEST_METHOD' => $requestMethod,
            'REQUEST_URI' => $requestUri
        ]);

        $request = Request::createFromEnvironment($environment);

        if ($requestData !== null) {
            $request = $request->withParsedBody($requestData);
        }

        $settings = require __DIR__ . '/../../src/settings.php';

        $app = new App($settings);

        $this->container = $app->getContainer();

        MainRegister::make()->register($app);

        return $app->process($request, $app->getContainer()['response']);
    }
}
