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
        $result = $this->registerCommand->execute($this->getParam('un'), $this->getParam('pwd'));
        
        if($result != 0) {
            $errors = [];
            if($result & \Application\RegisterCommand::Error_UserNameToShort) {
                $errors[] = "Username needs to have between 3 and 30 characters";
            }
            if($result & \Application\RegisterCommand::Error_InvalidPassword) {
                $errors[] = "Password needs to have atleast 1 character";
            }
            if($result & \Application\RegisterCommand::Error_UserNameUsed) {
                $errors[] = "Entered username is already used";
            }
            if(sizeof($errors) == 0) {
                $errors[] = 'Something went wrong.';
            }
            return $this->view('login', [
                'user' => $this->signedInUserQuery->execute(),
                'userName' => $this->getParam('un'),
                'errors' => $errors
            ]);
        }
        return $this->redirect('Home', 'Index'); 
    }
}
