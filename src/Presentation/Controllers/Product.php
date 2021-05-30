<?php

namespace Presentation\Controllers;

use Presentation\MVC\ViewResult;
use Presentation\MVC\Controller;

class Product extends Controller {
    public function __construct(
        private \Application\SignedInUserQuery $signedInUserQuery,
        private \Application\ProductsQuery $productsQuery,
        private \Application\ProductSearchQuery $productSearchQuery
    )
    {
        
    }
    public function GET_index(): ViewResult {
        return $this->view('productList', [
            'user' => $this->signedInUserQuery->execute(),
            'products' => $this->productsQuery->execute(),

        ]);
    }
    public function GET_search(): ViewResult {
        return $this->view('productSearch', [
            'user' => $this->signedInUserQuery->execute(),
            'products' => $this->tryGetParam('f', $value) ? $this->productSearchQuery->execute($value) : null,
            'filter' => $this->tryGetParam('f', $value) ? $value : null
        ]);
    }
}