<?php

namespace Laudis\Calculators\Models;

class PDOUserModel implements UserModel
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
    }

    public function listUsers() : array
    {
        $statement = $this->pdo->prepare("SELECT * FROM users");
        $statement->execute();
        $statement->bindColumn(1, $id, \PDO::PARAM_INT);
        $statement->bindColumn(2, $firstName, \PDO::PARAM_STR);
        $statement->bindColumn(3, $lastName, \PDO::PARAM_STR);
        $statement->bindColumn(4,$description,\PDO::PARAM_STR);
        $users = [];
        while ($statement->fetch(\PDO::FETCH_BOUND)) {
            $users[] = ['id' => $id, 'firstName' => $firstName, 'lastName' => $lastName,"description"=>$description];
        }
        if (empty($users) ){
            $users[] = ["error" => "no users found"];
        }
        return $users;
    }

    /**
     * add a user in the database
     * returns the user as array of data
     */

    public function addUser($firstName,$lastName,$description) : array
    {
        $output = [];
        if ($firstName == ""){
            return ["error" => "firstname needs to be filled in"];
        }
        if ($lastName == ""){
            return ["error" => "lastname needs to be filled in"];
        }
        $statement = $this->pdo->prepare("INSERT INTO users(firstname, lastname, descript)  VALUES (?,?,?)");
        $statement->execute([$firstName,$lastName,$description]);
        $output[] = ["firstName" => $firstName , "lastName" => $lastName,"description"=> $description];

        return $output;
    }

    /**
     * change a users firstname or lastname
     */
    public function updateUser($id, $newFirstName, $newLastName,$newDescription) : array
    {
        $getuser = $this->pdo->prepare("SELECT * from users WHERE id=?");
        $getuser->execute([$id]);
        $getuser->bindColumn(2,$oldFirstName,\PDO::PARAM_STR);
        $getuser->bindColumn(3,$oldLastName,\PDO::PARAM_STR);
        $getuser->bindColumn(4,$oldDescription,\PDO::PARAM_STR);
        $getuser->fetch(\PDO::FETCH_ORI_FIRST);
        $output = [];
        if ($newFirstName == ""){
            $newFirstName = $oldFirstName;
        }
        if ($newLastName == ""){
            $newLastName = $oldLastName;
        }
        if($newDescription == ""){
            $newDescription = $oldDescription;
        }
        if ($getuser->rowCount() == 0){
            $output[] =  ["user ID" => $id, "error" => "user not found"];
        } else {
            $statement = $this->pdo->prepare("UPDATE users SET firstname=?,lastname=?,descript=? WHERE id = ?");
            $statement->execute([$newFirstName,$newLastName,$newDescription,$id]);
        }
        $output[] = ["updated" => $id, "oldFirstName"=> $oldFirstName, "newFirstName" => $newFirstName,"oldLastName" => $oldLastName, "newLastName" => $newLastName, "old description" => $oldDescription, "new description" => $newDescription];
        return $output;
    }
    /**
     * delete a user with the userId
     */
    public function deleteUser($id) : array
    {       $output = [];
            $statement = $this->pdo->prepare("DELETE FROM users WHERE id=?");
            $statement->execute([$id]);
            $userRows = $statement->rowCount();
            $statement = $this->pdo->prepare("DELETE FROM posts WHERE id=?");
            $statement->execute([$id]);
            if ($userRows == 0){
                $output[] = ["error" => "user not found"];
            }
            $output[] = ["userRows deleted" => $userRows,"deleted posts" => "succes"];
            return $output;
    }
}
