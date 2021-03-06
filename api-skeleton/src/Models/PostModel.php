<?php

namespace Laudis\Calculators\Models;

interface PostModel
{

    /**
     * list all posts in the database
     * @return array
     */
    public function listAllPosts(): array;

    /**
     * @param $id
     * @return mixed
     */
    public function listPostsByID($id):array ;

    /**
     * add a post to the database with the id of the user
     * can be altered to firstname and lastname
     * @param $id
     * @param $text
     * @return array
     */
    public function addPost($id, $text ):array ;

    /**
     * delete a post from the database with the postId
     */
    public function deletePost($postId):array ;
}
