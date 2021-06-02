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
        $products = [];
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT products.id, name, producer, creatorId, username, image
            FROM products JOIN users ON (users.id = products.creatorId)',
            function () {
            }
        );
        $stat->bind_result($id, $name, $producer, $creatorId, $username, $image);
        while ($stat->fetch()) {
            $products[] = new \Application\Entities\Product($id, $name, $producer, $creatorId, $username, $image);
        }
        $stat->close();
        $con->close();
        return $products;
    }
    public function getProductById(int $productId): ?\Application\Entities\Product
    {
        $product = null;
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT products.id AS pid, name, producer, creatorId, username, image
            FROM products JOIN users ON (users.id = products.creatorId)
            WHERE products.id = ?',
            function ($s) use ($productId) {
                $s->bind_param('i', $productId);
            }
        );
        $stat->bind_result($id, $name, $producer, $creatorId, $username, $image);
        if ($stat->fetch()) {
            $product = new \Application\Entities\Product($id, $name, $producer, $creatorId, $username, $image);
        }
        $stat->close();
        $con->close();
        return $product;
    }

    
    public function getProductsForFilter(string $filter): array
    {
        $filter = "%$filter%";
        $products = [];
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT products.id, name, producer, creatorId, username,  image
            FROM products JOIN users ON (users.id = products.creatorId)
            WHERE name LIKE ? OR producer LIKE ?',
            function ($s) use ($filter) {
                $s->bind_param('ss', $filter, $filter);
            }
        );
        $stat->bind_result($id, $name, $producer, $creatorId, $username, $image);
        while ($stat->fetch()) {
            $products[] = new \Application\Entities\Product($id, $name, $producer, $creatorId, $username, $image);
        }
        $stat->close();
        $con->close();
        return $products;
    }

    public function getRatingsForProduct(int $productId): array
    {
        $ratings = [];
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT ratings.id, ratings.creatorId, username, productId, name, creationDate, rating, comment
             FROM ratings   JOIN users ON (users.id = ratings.creatorId)
                            JOIN products ON (products.id = ratings.productId)
             WHERE productId = ?
             ORDER BY creationDate DESC',
            function ($s) use ($productId) {
                $s->bind_param('i', $productId);
            }
        );
        $stat->bind_result($id, $creatorId, $username, $productId, $name, $creationDate, $rating, $comment);
        while ($stat->fetch()) {
            $ratings[] = new \Application\Entities\Rating($id, $creatorId, $username, $productId, $name, $creationDate, $rating, $comment);
        }
        $stat->close();
        $con->close();
        return $ratings;
    }
    public function getAvgRatingForProduct(int $productId): float
    {
        $ratingsAvg = 0;
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT AVG(rating) AS avg
             FROM ratings
             WHERE productId = ?',
            function ($s) use ($productId) {
                $s->bind_param('i', $productId);
            }
        );
        $stat->bind_result($ratingsAvg);
        $stat->fetch();


        $stat->close();
        $con->close();
        return $ratingsAvg ?? 0;
    }
    public function getCountOfRatingsForProduct(int $productId): int
    {
        $ratingsCount = 0;
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'SELECT COUNT(*) AS cnt
             FROM ratings
             WHERE productId = ?',
            function ($s) use ($productId) {
                $s->bind_param('i', $productId);
            }
        );
        $stat->bind_result($ratingsCount);
        $stat->fetch();

        $stat->close();
        $con->close();
        return $ratingsCount;
    }

    public function createOrUpdateRatingForProduct(int $creatorId, int $productId, int $rating, string $comment): ?int
    {
        $con = $this->getConnection();
        $con->autocommit(false);

        //check if rating exists
        $stat = $this->executeStatement(
            $con,
            'SELECT id
            FROM ratings 
            WHERE creatorId = ? AND productId = ? ',
            function ($s) use ($creatorId, $productId) {
                $s->bind_param('ii', $creatorId, $productId);
            }
        );
        $stat->bind_result($id);
        while ($stat->fetch());

        //No rating exists -> can create a new one
        if ($id == null) {
            $stat = $this->executeStatement(
                $con,
                'INSERT INTO ratings (creatorId, productId, creationDate, rating, comment) 
                VALUES (?, ?, CURDATE(), ?, ?)',
                function ($s) use ($creatorId, $productId, $rating, $comment) {
                    $s->bind_param('iiis', $creatorId, $productId, $rating, $comment);
                }
            );
            $id = $stat->insert_id;
        } else { //rating exists and needs to be updated
            $stat = $this->executeStatement(
                $con,
                'UPDATE ratings
                 SET creationDate = CURDATE(), rating = ?, comment = ?
                 WHERE id = ?',
                function ($s) use ($rating, $comment, $id) {
                    $s->bind_param('isi', $rating, $comment, $id);
                }
            );
        }
        $con->commit();
        $con->close();
        return $id;
    }
    public function deleteRatingForProduct(int $creatorId, int $productId): ?int
    {
        $con = $this->getConnection();

        //check if rating exists
        $stat = $this->executeStatement(
            $con,
            'DELETE             
            FROM ratings 
            WHERE creatorId = ? AND productId = ?',
            function ($s) use ($creatorId, $productId) {
                $s->bind_param('ii', $creatorId, $productId);
            }
        );
        $affectedRows = $con->affected_rows;
        $con->close();
        return $affectedRows;
    }
    public function createProduct(int $userId, string $productName, string $producerName, string $imgBlob): ?int
    {
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'INSERT INTO products (creatorId, name, producer, image) VALUES (?, ?, ?, ?)',
            function ($s) use ($userId, $productName, $producerName, $imgBlob) {
                $s->bind_param('isss', $userId, $productName, $producerName, $imgBlob);
            }
        );
        $productId = $stat->insert_id;
        $stat->close();
        $con->close();
        return $productId;
    }
    public function updateProduct(int $userId, int $productId, string $productName, string $producerName, string $imgBlob): ?int
    {
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'UPDATE products 
            SET name = ?, 
            producer = ?,
            image = ?
            WHERE id = ? AND creatorId = ?',
            function ($s) use ($productName, $producerName, $imgBlob, $productId, $userId) {
                $s->bind_param('sssii', $productName, $producerName, $imgBlob, $productId, $userId);
            }
        );
        $affectedRows = $con->affected_rows;
        $stat->close();
        $con->close();
        return $affectedRows;
    }
    public function updateProductWithoutImage(int $userId, int $productId, string $productName, string $producerName): ?int {
        $con = $this->getConnection();
        $stat = $this->executeStatement(
            $con,
            'UPDATE products 
            SET name = ?, 
            producer = ?
            WHERE id = ? AND creatorId = ?',
            function ($s) use ($productName, $producerName, $productId, $userId) {
                $s->bind_param('ssii', $productName, $producerName, $productId, $userId);
            }
        );
        $affectedRows = $con->affected_rows;
        $stat->close();
        $con->close();
        return $affectedRows;        
    }
}
