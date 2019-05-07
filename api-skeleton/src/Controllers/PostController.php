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
        $id = $params['id'] ;
        $posts = $this->postModel->listPostsByID($id);
        return $this->writeToResponse($response, ['posts' => $posts]);
    }

    public function listAllPosts(ServerRequestInterface $request, ResponseInterface $response):ResponseInterface
    {
        $posts = $this->postModel->listAllPosts();
        return $this->writeToResponse($response,['posts' => $posts]);
    }
    public function addPost(ServerRequestInterface $request, ResponseInterface $response, array $params): ResponseInterface{
        $body = $request->getParsedBody();
        $id = $body["id"];
        $text = $body['text'];
        $post = $this->postModel->addPost($id,$text);
        return $this->writeToResponse($response,["added" => $post]);
    }

    public function deletePost(ServerRequestInterface $request, ResponseInterface $response, array $params): ResponseInterface{
        $postID = $params["postID"];
        $post = $this->postModel->deletePost($postID);
        return $this->writeToResponse($response , ["deleted" => $post]);
    }
}



