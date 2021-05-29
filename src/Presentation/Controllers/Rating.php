<?php

namespace Presentation\Controllers;

use Presentation\MVC\ViewResult;
use Presentation\MVC\Controller;

class Rating extends Controller {
    public function __construct(
        private \Application\SignedInUserQuery $signedInUserQuery,
        private \Application\RatingsQuery $ratingsQuery,
        private \Application\ProductQuery $productQuery
    )
    {
        
    }
    public function GET_index(): ViewResult {
        $selectedProductId = $this->getParam('p');
        $selectedProduct = $this->productQuery->execute($selectedProductId);
        return $this->view('ratingList', [
            'user' => $this->signedInUserQuery->execute(),
            'product' => $selectedProduct,
            'ratings' => $this->ratingsQuery->execute($selectedProductId),
        ]);
    }
}