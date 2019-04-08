<?php

namespace Laudis\Calculators\Controllers;


use Laudis\Calculators\Contracts\ResponseWriterInterface;
use Laudis\Calculators\Models\UserModel;
use phpDocumentor\Reflection\Types\This;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;


/**
 * Class userController
 * @package controller
 * hier de parameters veraderen naar write to response (geef de data mee)
 */
class UserController extends BaseController
{
    private $userModel;

    public function __construct(ResponseWriterInterface $responseWriter, UserModel $userModel)
    {
        parent::__construct($responseWriter);
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

    public function deleteUser(RequestInterface $request, ResponseInterface $response, array $params): ResponseInterface
    {
        $id = $params['id'];
        $users =  $this->userModel->deleteUser($id);
        return $this->writeToResponse($response,["deleted"=>$users]);
    }

}



