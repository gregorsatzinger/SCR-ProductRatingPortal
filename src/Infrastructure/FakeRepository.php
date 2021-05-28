<?php

namespace Infrastructure;

use Application\Entities\User;

class FakeRepository implements
    \Application\Interfaces\UserRepository
{
    private $mockCategories;
    private $mockBooks;
    private $mockUsers;

    public function __construct()
    {
        // create mock data
        $this->mockUsers = array(
            array(1, 'scr4', 'scr4')
        );
    }
    public function getUser(int $id): ?User {
        foreach($this->mockUsers as $u) {
            if($u[0] === $id) {
                return new \Application\Entities\User($u[0], $u[1]);
            }
        }
        return null;
    }
    public function getUserForUserNameAndPassword(string $userName, string $password): ?User
    {
        foreach($this->mockUsers as $u) {
            if($u[1] === $userName && $u[2] === $password) {
                return new \Application\Entities\User($u[0], $u[1]);
            }
        }
        return null;
    }

}
