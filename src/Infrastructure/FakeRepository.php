<?php

namespace Infrastructure;

use Application\Entities\User;

class FakeRepository implements
    \Application\Interfaces\UserRepository,
    \Application\Interfaces\RatingRepository,
    \Application\Interfaces\ProductRepository
{
    private $mockCategories;
    private $mockBooks;
    private $mockUsers;

    public function __construct()
    {
        // create mock data
        $this->mockUsers = array(
            array(1, 'admin', password_hash('a', PASSWORD_DEFAULT)),
            array(2, 'user2', password_hash('u', PASSWORD_DEFAULT)),
            array(3, 'user3', password_hash('u', PASSWORD_DEFAULT))
        );

        $this->mockProducts = array(
            array(1, "Produkt A", "Hersteller A", 1),
            array(2, "Produkt B", "Hersteller A", 1),
            array(3, "Produkt C", "Hersteller B", 2),
            array(4, "Produkt D", "Hersteller C", 2)
        );

        $this->mockRatings = array(
            array(1, 2, 1, "2021-05-28", 4, "Das ist ein Rating"),
            array(2, 3, 1, "2021-05-28", 4, "Das ist ein Rating"),
            array(3, 3, 2, "2021-05-28", 3, "Das ist ein Rating")
        );
    }
    public function getUser(int $id): ?User
    {
        foreach ($this->mockUsers as $u) {
            if ($u[0] === $id) {
                return new \Application\Entities\User($u[0], $u[1]);
            }
        }
        return null;
    }
    public function getUserForUserNameAndPassword(string $userName, string $password): ?User
    {
        foreach ($this->mockUsers as $u) {
            if ($u[1] === $userName && password_verify($password, $u[2])) {
                return new \Application\Entities\User($u[0], $u[1]);
            }
        }
        return null;
    }
    public function createUser(string $userName, string $password): ?User
    {
        $id = 0;
        //check if user does exist
        foreach ($this->mockUsers as $u) {
            if ($u[1] === $userName) {
                return null;
            }
            $id = $u[0];
        }
        $this->mockUsers[] = array($id + 1, $userName, password_hash($password, PASSWORD_DEFAULT));
        return $this->getUserForUserNameAndPassword($userName, $password);
    }

    public function getProducts(): array
    {
        $res = [];
        foreach ($this->mockProducts as $c) {
            $res[] = new \Application\Entities\Product($c[0], $c[1], $c[2], $c[3]);
        }
        return $res;
    }
    public function getRatingsForProduct(int $productId): array
    {
        $res = [];
        foreach ($this->mockRatings as $c) {
            $res[] = new \Application\Entities\Rating($c[0], $c[1], $c[2], $c[3], $c[4], $c[5]);
        }
        return $res;
    }
}
