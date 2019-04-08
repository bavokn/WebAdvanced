<?php

namespace Laudis\Calculators\Models;


use phpDocumentor\Reflection\DocBlock\Tags\Param;

class PDOUserModel implements UserModel
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function listUsers() : array
    {
        $statement = $this->pdo->prepare("SELECT * FROM users");
        $statement->execute();
        $statement->bindColumn(1, $id, \PDO::PARAM_INT);
        $statement->bindColumn(2, $firstName, \PDO::PARAM_STR);
        $statement->bindColumn(3, $lastName, \PDO::PARAM_STR);

        $users = [];
        while ($statement->fetch(\PDO::FETCH_BOUND)) {
            $users[] = ['id' => $id, 'firstName' => $firstName, 'LastName' => $lastName];
        }
        return $users;
    }


    /**
     * add a user in the database
     */
    public function addUser()
    {
        // TODO: Implement addUser() method.
    }

    /**
     * change a users firstname or lastname
     */
    public function updateUser($id, $firstName, $lastName)
    {
        // TODO: Implement updateUser() method.
    }

    /**
     * delete a user with the userId
     */
    public function deleteUser($id)
    {
        try {
            $statement = $this->pdo->prepare("DELETE FROM users  WHERE id = $id");
            $statement->execute();

            $getUser = $this->pdo->prepare("SELECT * FROM posts WHERE id=$id");
            $getUser->execute();
            $statement->bindColumn(1, $firstname, \PDO::PARAM_STR);
            $statement->bindColumn(2, $lastname, \PDO::PARAM_STR);

            $user = [];
            while ($statement->fetch(\PDO::FETCH_BOUND)) {
                $user[] = ["deleted "=> "succes ",'firstName' => $firstname, '$lastName' => $lastname];
            }

            return $user;
        }
        catch (\PDOException $e){
            return $e->getMessage();
        }
    }
}
