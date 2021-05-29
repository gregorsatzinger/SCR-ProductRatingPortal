<?php

namespace Application\Interfaces;

interface UserRepository
{
    public function getUser(int $id): ?\Application\Entities\User;
    public function getUserForUserNameAndPassword(string $username, string $password): ?\Application\Entities\User;
    public function createUser(string $username, string $password): ?\Application\Entities\User;
}
