<?php

namespace Application\Interfaces;

interface UserRepository
{
    public function getUser(int $id): ?\Application\Entities\User;
    public function getUserForUserNameAndPassword(string $userName, string $password): ?\Application\Entities\User;
    public function createUser(string $userName, string $password): ?\Application\Entities\User;
}
