<?php

namespace Presentation\Controllers;

use Presentation\MVC\ViewResult;
use Presentation\MVC\Controller;

class Home extends Controller {
    public function __construct(
        private \Application\SignedInUserQuery $signedInUserQuery
    )
    {
        
    }
    public function GET_index(): ViewResult {
        return $this->view('home', [
            'user' => $this->signedInUserQuery->execute()
        ]);
    }
}