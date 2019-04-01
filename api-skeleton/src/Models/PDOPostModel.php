<?php

namespace Models;

use Models\PostModel;

class PDOPostModel implements PostModel
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function listPosts($Userid)
    {
        $statement = $this->pdo->prepare('SELECT * FROM posts WHERE id = :Userid ');
        $statement->execute();
        $statement->bindColumn(1, $postid, \PDO::PARAM_INT);
        $statement->bindColumn(1, $id, \PDO::PARAM_INT);
        $statement->bindColumn(2, $text, \PDO::PARAM_STR);

        $posts = [];
        while ($statement->fetch(\PDO::FETCH_BOUND)) {
            $posts[] = ['postID' => $postid, 'post' => $text];
        }
        return $posts;
    }

    /**
     * Validation can happen via Validator class
     * @param $id
     */
    private function validateId($id){
        if (!(is_string($id) &&  preg_match("/^[0-9]+$/", $id) && (int)$id > 0)) {
            throw new \InvalidArgumentException("id moet een int > 0 bevatten ");
        }
    }

    private function validateName($name)
    {
        if (!(is_string($name) && strlen($name) >= 2)) {
            throw new \InvalidArgumentException("name moet een string met minstens 1 karakters zijn");
        }
    }

}
