<?php

namespace Controllers;


use http\Message\Body;
use Laudis\Calculators\Contracts\ResponseWriterInterface;
use Laudis\Calculators\Controllers\BaseController;
use Models\PDOUserModel;
use Models\PostModel;
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
class PostController extends BaseController
{
    private $postModel;

    public function __construct(ResponseWriterInterface $responseWriter, PostModel $postModel)
    {
        BaseController::__construct($responseWriter);
        $this->postModel = $postModel;
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function listUsers(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = $request['id'];
        $posts = $this->postModel->listPosts($id);
        return $this->writeToResponse($response, ['posts' => $posts]);
    }
}



