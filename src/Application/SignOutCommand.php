<?php

namespace Application;

class SignOutCommand
{
    public function __construct(
        private \Application\Services\AuthenticationService $authenticationService
    ) {
    }
    public function execute(): void
    {
        $this->authenticationService->signOut();
    }
}
