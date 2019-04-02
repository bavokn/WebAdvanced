<?php

namespace Laudis\Calculators\Models;

use http\Client\Curl\User;
use Laudis\Calculators\Models\UserModel;

class PDOUserModel implements UserModel
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function listUsers()
    {
        $statement = $this->pdo->prepare('SELECT * FROM users');
        $statement->execute();
        $statement->bindColumn(1, $id, \PDO::PARAM_INT);
        $statement->bindColumn(2, $firstName, \PDO::PARAM_STR);

        $persons = [];
        while ($statement->fetch(\PDO::FETCH_BOUND)) {
            $persons[] = ['id' => $id, 'name' => $firstName];
        }
        return $persons;
    }


    public function addUserByIdAndName($id, $firstName,$lastName)
    {
        $this->validateId($id);
        $this->validateName($firstName);
        $this->validateName($lastName);

        $statement = $this->pdo->prepare('INSERT into users(id,firstname, lastname) VALUES (:id,:firstName,:lastName) ON DUPLICATE KEY UPDATE id=:id, firstName=:firstName, lastName =: lastName');
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->bindParam(':name', $name, \PDO::PARAM_STR);
        $statement->execute();

        return ['id' => $id, 'firstName' => $firstName,'lastName' => $lastName];
    }


    public function idExists($id)
    {
        $this->validateId($id);

        $statement = $this->pdo->prepare('INSERT into users(id,firstName,lastName) VALUES (:id,:firstName,:lastName)');
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->bindParam(':name', $name, \PDO::PARAM_STR);
        $statement->execute();

        $statement = $this->pdo->prepare('SELECT id from users WHERE id=:id');
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
        if ($statement->fetch() === FALSE) {
            return FALSE;
        }
        return TRUE;
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
