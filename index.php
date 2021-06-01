<?php
// === register autoloader

use Infrastructure\Repository;

spl_autoload_register(function ($class) {
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
});

$sp = new \ServiceProvider();
// Application
$sp->register(\Application\RatingCreationQuery::class);
$sp->register(\Application\RatingDeleteQuery::class);
$sp->register(\Application\RatingsQuery::class);
$sp->register(\Application\RegisterCommand::class);
$sp->register(\Application\SignInCommand::class);
$sp->register(\Application\SignedInUserQuery::class);
$sp->register(\Application\SignOutCommand::class);
$sp->register(\Application\ProductsQuery::class);
$sp->register(\Application\ProductSearchQuery::class);
$sp->register(\Application\ProductQuery::class);

$sp->register(\Application\Services\AuthenticationService::class);

// Infrastructure

/*
$sp->register(\Infrastructure\FakeRepository::class, isSingleton: true);
$sp->register(\Application\Interfaces\UserRepository::class, \Infrastructure\FakeRepository::class);
$sp->register(\Application\Interfaces\ProductRepository::class, \Infrastructure\FakeRepository::class);
$sp->register(\Application\Interfaces\RatingRepository::class, \Infrastructure\FakeRepository::class);
*/


$sp->register(\Infrastructure\Repository::class, function() {
    return new Repository('localhost', 'root', '', 'productratingportal');
}, isSingleton: true);
$sp->register(\Application\Interfaces\UserRepository::class, \Infrastructure\Repository::class);
$sp->register(\Application\Interfaces\ProductRepository::class, \Infrastructure\Repository::class);
$sp->register(\Application\Interfaces\RatingRepository::class, \Infrastructure\Repository::class);


$sp->register(\Infrastructure\Session::class, isSingleton: true);
$sp->register(\Application\Interfaces\Session::class, \Infrastructure\Session::class);

// Presentation
$sp->register(\Presentation\MVC\MVC::class, function () {
    return new \Presentation\MVC\MVC();
}, isSingleton: true);

$sp->register(\Presentation\Controllers\Home::class);
$sp->register(\Presentation\Controllers\User::class);
$sp->register(\Presentation\Controllers\Rating::class);
$sp->register(\Presentation\Controllers\Product::class);

$sp->resolve(\Presentation\MVC\MVC::class)->handleRequest($sp);
