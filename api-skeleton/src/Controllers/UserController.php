<?php

namespace Laudis\Calculators\Controllers;


use Laudis\Calculators\Contracts\ResponseWriterInterface;
use Laudis\Calculators\Models\UserModel;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


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
    public function listUsers(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $users = $this->userModel->listUsers();
        return $this->writeToResponse($response, ['users' => $users]);
    }

    public function deleteUser(ServerRequestInterface $request, ResponseInterface $response, array $params): ResponseInterface
    {
        $id = $params['id'];
        $users =  $this->userModel->deleteUser($id);
        return $this->writeToResponse($response,["deleted"=>$users]);
    }

    public function addUser(ServerRequestInterface $request, ResponseInterface $response, array $params): ResponseInterface{
        $body = $request->getParsedBody();
        $firstName = $body["firstName"];
        $lastName = $body["lastName"];
        $description = $body["description"];
        $user = $this->userModel->addUser($firstName,$lastName,$description);
        return $this->writeToResponse($response,["added" => $user]);
    }

    //description is null;
    public function updateUser(ServerRequestInterface $request, ResponseInterface $response, array $params): ResponseInterface{
        $body = $request->getParsedBody();
        $id = $body["id"];
        $newFirstName= $body['firstName'];
        $newLastName = $body['lastName'];
        $description = $body["description"];

        $update = $this->userModel->updateUser($id,$newFirstName,$newLastName,$description);

        return $this->writeToResponse($response,["updated" => $update]);
    }
}



