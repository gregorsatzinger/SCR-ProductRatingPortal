<?php

namespace Presentation\Controllers;

class User extends \Presentation\MVC\Controller
{
    public function __construct(
        private \Application\RegisterCommand $registerCommand,
        private \Application\SignOutCommand $signOutCommand,
        private \Application\SignInCommand $signInCommand,
        private \Application\SignedInUserQuery $signedInUserQuery
    ) {
    }
    public function GET_LogIn(): \Presentation\MVC\ActionResult
    {
        $user = $this->signedInUserQuery->execute();
        // only show login view when there is no authenticated user
        if($user != null) {
            return $this->redirect('Home', 'Index');
        }
        return $this->view('login', [
            'user' => $this->signedInUserQuery->execute(),
            'userName' => ''
        ]);
    }
    public function POST_LogIn(): \Presentation\MVC\ActionResult
    {
        $ok = $this->signInCommand->execute($this->getParam('un'), $this->getParam('pwd'));
        if(!$ok) {
            return $this->view('login', [
                'user' => $this->signedInUserQuery->execute(),
                'userName' => $this->getParam('un'),
                'errors' => ['The combination of username and password you have entered is incorrect']
            ]);
        } 

        return $this->redirect('Home', 'Index'); 
    }
    public function POST_LogOut(): \Presentation\MVC\ActionResult
    {
        $this->signOutCommand->execute();
        return $this->redirect('Home', 'Index');
    }
    public function POST_Register(): \Presentation\MVC\ActionResult
    {
        $ok = $this->registerCommand->execute($this->getParam('un'), $this->getParam('pwd'));
        if(!$ok) {
            return $this->view('login', [
                'user' => $this->signedInUserQuery->execute(),
                'userName' => $this->getParam('un'),
                'errors' => ['Username or password does not fullfill our security requirements']
            ]);
        }
        return $this->redirect('Home', 'Index'); 
    }
}
