<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class wishlistComponents extends sfComponents
{ 
  public function executeShowWishlist(sfWebRequest $request)
    {
        $this->wishlist_user = Doctrine_Core::getTable('WishlistUser')->find(array($request->getParameter('wishlistuser_id')));
        $this->forward404Unless($this->wishlist_user);

        $this->wishlist_items = $this->wishlist_user->getWishlistItems();
    }
}
