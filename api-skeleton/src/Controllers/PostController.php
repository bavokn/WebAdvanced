<?php

namespace Laudis\Calculators\Controllers;

use Laudis\Calculators\Contracts\ResponseWriterInterface;
use Laudis\Calculators\Models\PostModel;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class userController
 * @package controller
 * hier de parameters veraderen naar write to response (geef de data mee)
 */
class PostController extends BaseController
{
    private $postModel;

    public function __construct(ResponseWriterInterface $responseWriter, PostModel $postModel)
    {
        parent::__construct($responseWriter);
        $this->postModel = $postModel;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $params
     * @return ResponseInterface
     */
    public function listPostsByID(ServerRequestInterface $request, ResponseInterface $response, array $params): ResponseInterface
    {
        //get the id from serverrequestinterface or params
        // TODO: you can find the id in the `params` parameter because the variable defined in the route
        //  /twitter/posts/{id} is not defined in the request, but in the route.
        //  You can only get variables from a request if they are explicitly given to you by the client
        //  (eg through a form or a json type)
        $id = $params['id'];
        $posts = $this->postModel->listPostsByID($id);
        return $this->writeToResponse($response, ['posts' => $posts]);
    }

    public function listAllPosts(ServerRequestInterface $request, ResponseInterface $response):ResponseInterface
    {
        $posts = $this->postModel->listAllPosts();
        return $this->writeToResponse($response,['posts' => $posts]);
    }

}



