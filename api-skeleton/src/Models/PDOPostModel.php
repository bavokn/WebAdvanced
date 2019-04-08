<?php

namespace Laudis\Calculators\Models;

class PDOPostModel implements PostModel
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function listPostsByID($Userid)
    {
        //  TODO I assume :Userid will not work, you will want to use $Userid and double instead of single quotes.
        //      Please read this also:
        //      https://stackoverflow.com/questions/134099/are-pdo-prepared-statements-sufficient-to-prevent-sql-injection
        //      You are vulnerable to sql injections if special precautions aren't taken,
        //      Don't worry about these precautions now, we will fix them later
        $statement = $this->pdo->prepare("SELECT * FROM posts WHERE id = $Userid");
        $statement->execute();
        $statement->bindColumn(1, $postid, \PDO::PARAM_INT);
        $statement->bindColumn(2, $id, \PDO::PARAM_INT);
        $statement->bindColumn(3, $text, \PDO::PARAM_STR);

        $posts = [];
        while ($statement->fetch(\PDO::FETCH_BOUND)) {
            $posts[] = ['postID' => $postid, 'post' => $text];
        }
        return $posts;
    }

    /**
     * TODO: I have defined the return type for you, this is just a heads up
     * @return array
     */
    public function listAllPosts(): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM posts");
        $statement->execute();
        $statement->bindColumn(1, $postid, \PDO::PARAM_INT);
        $statement->bindColumn(2, $id, \PDO::PARAM_INT);
        $statement->bindColumn(3, $text, \PDO::PARAM_STR);

        $posts = [];
        while ($statement->fetch(\PDO::FETCH_BOUND)) {
            $posts[] = ['postID' => $postid, 'userID' => $id, 'post' => $text];
        }
        return $posts;
    }

    /**
     * add a post to the database with the id of the user
     * can be altered to firstname and lastname
     * @param $id
     */
    public function addPost($id)
    {
        // TODO: Implement addPost() method.
    }

    /**
     * delete a post from the database with the postId
     */
    public function deletePost($postId)
    {
        // TODO: Implement deletePost() method.
    }
}
