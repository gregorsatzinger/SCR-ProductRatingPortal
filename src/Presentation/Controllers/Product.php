<?php

namespace Presentation\Controllers;

use Presentation\MVC\ViewResult;
use Presentation\MVC\Controller;
use Presentation\MVC\ActionResult;

class Product extends Controller {
    public function __construct(
        private \Application\SignedInUserQuery $signedInUserQuery,
        private \Application\ProductsQuery $productsQuery,
        private \Application\ProductSearchQuery $productSearchQuery,
        private \Application\ProductCreateQuery $productCreateQuery,
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
    public function GET_create(): ViewResult {
        return $this->view('productCreate', [
            'user' => $this->signedInUserQuery->execute(),
            'producerName' => '',
            'productName' => ''
        ]);
    }

    public function POST_Create(): ActionResult {
        $productName = $this->getParam('pn');
        $producerName = $this->getParam('pc');

        $result = $this->productCreateQuery->execute($productName, $producerName);

        //error occured
        if($result != 0) {
            $errors = [];
            if(sizeof($errors) == 0) {
                $errors[] = 'Something went wrong.';
            }

            return $this->view('productCreate', [
                'user' => $this->signedInUserQuery->execute(),
                'producerName' => $productName,
                'productName' => $producerName
            ]);
        } else {
            return $this->redirect('Product', 'Index');
        }
    }
}