<?php

namespace Controllers;


use Laudis\Calculators\Contracts\ResponseWriterInterface;
use Laudis\Calculators\Controllers\BaseController;
use Models\UserModel;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;


/**
 * Class userController
 * @package controller
 * @TODO correct casing
 * @todo namespacing need plural
 * @todo preflight cors controller and base controller were there to help
 * hier de parameters veraderen naar write to response (geef de data mee)
 */
class UserController extends BaseController
{
    private $userModel;

    public function __construct(ResponseWriterInterface $responseWriter, UserModel $userModel)
    {
        BaseController::__construct($responseWriter);
        $this->userModel = $userModel;
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function listUsers(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $users = $this->userModel->listUsers();
        return $this->writeToResponse($response, ['users' => $users]);
    }
}



