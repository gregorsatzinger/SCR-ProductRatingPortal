<?php

namespace Presentation\Controllers;

use Presentation\MVC\ViewResult;
use Presentation\MVC\Controller;
use Presentation\MVC\ActionResult;

class Rating extends Controller {
    public function __construct(
        private \Application\SignedInUserQuery $signedInUserQuery,
        private \Application\RatingsQuery $ratingsQuery,
        private \Application\ProductQuery $productQuery,
        private \Application\RatingCreationQuery $ratingCreationQuery
    )
    {
        
    }
    public function GET_index(): ViewResult {
        $selectedProductId = $this->getParam('p');
        $selectedProduct = $this->productQuery->execute($selectedProductId);
        $user = $this->signedInUserQuery->execute();
        $ratings = $this->ratingsQuery->execute($selectedProductId);
        $rating = null;
        foreach($ratings as $r) {
            if($r->getCreatorName() == $user->getUserName()) {
                $rating = $r;
            }
        }
        return $this->view('ratingList', [
            'user' => $user,
            'product' => $selectedProduct,
            'ratings' => $ratings,
            'rating' => $rating
        ]);
    }
    public function POST_send(): ActionResult {
        $rating = $this->getParam('rt');
        $comment = $this->getParam('ct');
        $selectedProductId = $this->getParam('p');
        $selectedProduct = $this->productQuery->execute($selectedProductId);
        
        $result = $this->ratingCreationQuery->execute($selectedProductId, $rating, $comment);
        
        //error occured
        if($result != 0) {
            $errors = [];
            if($result & \Application\RatingCreationQuery::Error_NotAuthenticated) {
                $errors[] = "You need to be logged in to create ratings";
            }
            if($result & \Application\RatingCreationQuery::Error_DbErrorOccured) {
                $errors[] = "Error_DbErrorOccured";
            }


            return $this->view('orderForm', [
                'user' => $this->signedInUserQuery->execute(),
                'product' => $selectedProduct,
                'ratings' => $this->ratingsQuery->execute($selectedProductId),
                'errors' => $errors
            ]);
        } else {
            return $this->redirect('Rating', 'Index', ['p' => $selectedProductId]); 
        }
    }    
}