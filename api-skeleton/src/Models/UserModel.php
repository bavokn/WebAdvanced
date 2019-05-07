<?php

namespace Laudis\Calculators\Models;

interface UserModel
{
    /**
     * lists all users in database
     * @return array of users
     */
    public function listUsers() : array;

    /**
     * add a user in the database
     */
    public function addUser($firstName,$lastName,$description ):array;

    /**
     * change a users firstname or lastname
     */
    public function updateUser($id, $firstName, $lastName,$description ):array;

    /**
     * delete a user with the userId
     */
    public function deleteUser($id):array;

}
