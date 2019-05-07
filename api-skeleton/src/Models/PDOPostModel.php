<?php

namespace Laudis\Calculators\Models;

class PDOPostModel implements PostModel
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        //$pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
    }

    public function listPostsByID($Userid) :array
    {
        $statement = $this->pdo->prepare("SELECT * FROM posts WHERE  id = $Userid");
        $statement->execute();
        $statement->bindColumn(1, $postid, \PDO::PARAM_INT);
        $statement->bindColumn(2, $id, \PDO::PARAM_INT);
        $statement->bindColumn(3, $text, \PDO::PARAM_STR);

        $selectUser = $this->pdo->prepare("SELECT * FROM users WHERE id = $Userid");
        $selectUser->execute();
        $selectUser->bindColumn(2, $firstName, \PDO::PARAM_STR);
        $selectUser->bindColumn(3, $lastName, \PDO::PARAM_STR);
        $posts = [];
        $selectUser->fetch(\PDO::FETCH_ORI_FIRST);
        while ($statement->fetch(\PDO::FETCH_BOUND)) {
            $posts[] = ["firstName"=>$firstName,"lastName"=>$lastName,'userID'=>$id,'postID' => $postid, 'post' => $text];
        }
        if (empty($selectUser->fetch(\PDO::FETCH_BOUND))){
            $posts[] = ["User ID" =>$Userid,"error" => "no posts found"];
        }
        return $posts;
    }

    /**
     *
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
            $selectUser = $this->pdo->prepare("SELECT * FROM users WHERE id = $id");
            $selectUser->execute();
            $selectUser->bindColumn(2, $firstName, \PDO::PARAM_STR);
            $selectUser->bindColumn(3, $lastName, \PDO::PARAM_STR);
            $selectUser->fetchAll();
            $posts[] = ["firstName"=>$firstName,"lastName"=>$lastName,'userID'=>$id,'postID' => $postid, 'post' => $text];
        }
        if (empty($posts)){

            $posts[] =  ["error" => "no posts found"];
        }
        return $posts;
    }

    /**
     * add a post to the database with the id of the user
     * can be altered to firstname and lastname
     * @param $id
     * @param $text
     * @return array
     */
    public function addPost($id, $text):array
    {
            $getUser = $this->pdo->prepare("select * from users where id=?");
            $getUser->execute([$id]);
            $getUser->bindColumn(2, $firstName, \PDO::PARAM_STR);
            $getUser->bindColumn(3, $lastName, \PDO::PARAM_STR);
            $getUser->fetchAll(\PDO::FETCH_ORI_FIRST);
            $user = [];
            if (empty($firstName)){
                $user[] = ["user ID" => $id, "error" => "user not found"];
                return $user;
            }
            $post = [];
            $statement = $this->pdo->prepare("INSERT INTO posts(id, post)  VALUES (?,?)");
            $statement->execute([$id, $text]);
            $statement->bindColumn(1, $id, \PDO::PARAM_INT);
            $statement->bindColumn(2, $text, \PDO::PARAM_STR);

            $post [] = ["userID" => $id, "firstname" => $firstName, "lastname" => $lastName, "post" => $text];

        return $post;
    }

    /**
     * delete a post from the database with the postId
     */
    public function deletePost($postId):array
    {
        $statement = $this->pdo->prepare("DELETE FROM posts WHERE postID = $postId");
        $statement->execute();
        $post = [];
        if ($statement->rowCount() == 0){
            $post[] = ["postID" => $postId,"deleted"=>"postID not found"];
        }else{
            $post[] = ["postID" => $postId, "deleted"=>"succes"];
        }
        return $post;
    }
}
