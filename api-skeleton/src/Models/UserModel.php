<?php

namespace Laudis\Calculators\Models;

interface UserModel
{
    /**
     * lists all users in database
     * @return array of users
     */
    public function listUsers() : array ;

    /**
     * add a user in the database
     */
    public function addUser();

    /**
     * change a users firstname or lastname
     */
    public function updateUser($id, $firstName, $lastName);

    /**
     * delete a user with the userId
     */
    public function deleteUser($id);
}
