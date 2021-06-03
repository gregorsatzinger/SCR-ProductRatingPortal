<?php

namespace Presentation\Controllers;

use Presentation\MVC\ViewResult;
use Presentation\MVC\Controller;
use Presentation\MVC\ActionResult;

class Product extends Controller {
    public function __construct(
        private \Application\SignedInUserQuery $signedInUserQuery,
        private \Application\ProductsQuery $productsQuery,
        private \Application\ProductQuery $productQuery,
        private \Application\ProductSearchQuery $productSearchQuery,
        private \Application\ProductCreationCommand $productCreationCommand
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
    public function GET_edit(): ViewResult {
        $user = $this->signedInUserQuery->execute();
        $productId = $this->tryGetParam('p', $value) ? $value : null;
        
        //Only user who created the product is allowed to see it
        if($productId != null || $user == null) {
            $errors[] = 'Access denied';
            if($user == null) {
                return $this->view('productList', [
                    'user' => $user,
                    'products' => $this->productsQuery->execute(),
                    'errors' => $errors
                ]);
            }
            $product = $this->productQuery->execute($productId);
            if($product->getCreatorName() != $user->getUserName()) {
                return $this->view('productList', [
                    'user' => $user,
                    'products' => $this->productsQuery->execute(),
                    'errors' => $errors
                ]);
            }
        }


        $productName = $this->tryGetParam('pn', $value) ? $value : '';
        $producerName = $this->tryGetParam('pc', $value) ? $value : '';
        return $this->view('productCreate', [
            'user' => $user,
            'producerName' => $producerName,
            'productName' => $productName,
            'productId' => $productId
        ]);
    }

    public function POST_send(): ActionResult {
        $productName = $this->getParam('pn');
        $producerName = $this->getParam('pc');
        $productId = $this->tryGetParam('p', $value) ? (int)$value : null;

        $result = $this->productCreationCommand->execute($productId, $productName, $producerName, $_FILES['img']['tmp_name']);

        //error occured
        if($result != 0) {
            $errors = [];
            if($result & \Application\ProductCreationCommand::Error_NotAuthenticated) {
                $errors[] = "You need to be logged in to create ratings";
            }
            if($result & \Application\ProductCreationCommand::Error_InvalidProductName) {
                $errors[] = "Enter product name";
            }
            if($result & \Application\ProductCreationCommand::Error_InvalidProducer) {
                $errors[] = "Enter producer";
            }
            if($result & \Application\ProductCreationCommand::Error_InvalidImage) {
                $errors[] = "Select valid image";
            }
            if($result & \Application\ProductCreationCommand::Error_DbErrorOccured) {
                $errors[] = "Error_DbErrorOccured";
            }
            if(sizeof($errors) == 0) {
                $errors[] = 'Something went wrong.';
            }

            return $this->view('productCreate', [
                'user' => $this->signedInUserQuery->execute(),
                'producerName' => $productName,
                'productName' => $producerName,
                'productId' => $productId,
                'errors' => $errors
            ]);
        } else {
            return $this->redirect('Product', 'Index');
        }
    } 
}