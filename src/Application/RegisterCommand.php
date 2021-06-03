<?php

namespace Application;

class RegisterCommand
{
    const Error_UserNameToShort = 0x01;
    const Error_InvalidPassword = 0x02;
    const Error_UserNameUsed = 0x04;

    public function __construct(
        private \Application\Services\AuthenticationService $authenticationService,
        private \Application\Interfaces\UserRepository $userRepository
    ) {
    }
    public function execute(string $userName, string $password): int
    {
        $errors = 0;
        if (strlen($userName) < 3 || strlen($userName) > 30) {
            $errors |= self::Error_UserNameToShort;
        }
        if (strlen($password) == 0) {
            $errors |= self::Error_InvalidPassword;
        }
        if ($errors == 0) {
            $this->authenticationService->signOut();
            $user = $this->userRepository->createUser($userName, $password);
            if ($user == null) {
                $errors |= self::Error_UserNameUsed;
            } else {
                $this->authenticationService->signIn($user->getId());
            }
        }
        return $errors;
    }
}
