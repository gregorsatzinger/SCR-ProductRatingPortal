<?php

namespace Infrastructure;

use Application\Entities\User;

class Repository implements
    \Application\Interfaces\UserRepository,
    \Application\Interfaces\RatingRepository,
    \Application\Interfaces\ProductRepository
{
    private $server;
    private $userName;
    private $password;
    private $database;

    public function __construct(string $server, string $userName, string $password, string $database)
    {
        $this->server = $server;
        $this->userName = $userName;
        $this->password = $password;
        $this->database = $database;
    }

    // === private helper methods ===

    private function getConnection()
    {
        $con = new \mysqli($this->server, $this->userName, $this->password, $this->database);
        if (!$con) {
            die('Unable to connect to database. Error: ' . mysqli_connect_error());
        }
        return $con;
    }

    private function executeQuery($connection, $query)
    {
        $result = $connection->query($query);
        if (!$result) {
            die("Error in query '$query': " . $connection->error);
        }
        return $result;
    }

    private function executeStatement($connection, $query, $bindFunc)
    {
        $statement = $connection->prepare($query);
        if (!$statement) {
            die("Error in prepared statement '$query': " . $connection->error);
        }
        $bindFunc($statement);
        if (!$statement->execute()) {
            die("Error executing prepared statement '$query': " . $statement->error);
        }
        return $statement;
    }

    // === public methods ===

    public function getUser(int $id): ?User
    {
        $user = null;
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT id, username FROM users WHERE id = ?',
            function ($s) use ($id) {
                $s->bind_param('i', $id);
            }
        );
        $stat->bind_result($id, $username);
        if ($stat->fetch()) {
            $user = new \Application\Entities\User($id, $username);
        }
        $stat->close();
        $con->close();
        return $user;
    }
    public function getUserForUserNameAndPassword(string $username, string $password): ?User
    {
        $user = null;
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT id, passwordHash FROM users WHERE username = ?',
            function ($s) use ($username) {
                $s->bind_param('s', $username);
            }
        );
        $stat->bind_result($id, $passwordHash);
        if ($stat->fetch() && password_verify($password, $passwordHash)) {
            $user = new \Application\Entities\User($id, $username);
        }
        $stat->close();
        $con->close();
        return $user;
    }
    public function createUser(string $username, string $password): ?User
    {
        $user = null;
        $con = $this->getConnection();
        $stat = $con->prepare(
            'INSERT INTO users (username, passwordHash)
             VALUES (?, ?);'
        );
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stat->bind_param("ss", $username, $passwordHash);
        $stat->execute();

        $stat->close();
        $con->close();

        return $this->getUserForUserNameAndPassword($username, $password);
    }

    public function getProducts(): array
    {
        return [];
    }
    public function getRatingsForProduct(int $productId): array
    {
        return [];
    }
}
