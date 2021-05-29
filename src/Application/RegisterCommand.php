<?php

namespace Application;

class RegisterCommand {

    public function __construct(
        private \Application\Services\AuthenticationService $authenticationService,
        private \Application\Interfaces\UserRepository $userRepository
    ) {
    }
    public function execute(string $userName, string $password): bool
    {
        $this->authenticationService->signOut();
        $user = $this->userRepository->createUser($userName, $password);
        if($user != null) {
            $this->authenticationService->signIn($user->getId());
            return true;
        }
        return false;
    }
}