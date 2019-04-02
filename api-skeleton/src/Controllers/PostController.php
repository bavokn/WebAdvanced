<?php

namespace Laudis\Calculators\Controllers;

use Laudis\Calculators\Contracts\ResponseWriterInterface;
use Laudis\Calculators\Controllers\BaseController;
use Models\PostModel;
use phpDocumentor\Reflection\Types\Parent_;
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
        // TODO - use parent instead of BaseController
        parent::__construct($responseWriter);
        $this->postModel = $postModel;
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function listUsers(ServerRequestInterface $request, ResponseInterface $response, array $params): ResponseInterface
    {
        $id = $params['id'];
        $posts = $this->postModel->listPosts($id);
        return $this->writeToResponse($response, ['posts' => $posts]);
    }
}



