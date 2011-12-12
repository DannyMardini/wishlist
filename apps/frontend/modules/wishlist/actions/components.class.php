<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class wishlistComponents extends sfComponents
{ 
  public function executeShowWishlist()
  {
    $this->wishlist_user = WishlistUserTable::getInstance()->find(array($this->wishlistuser_id));
    $this->wishlist_items = $this->wishlist_user->getWishlistItems();
  }
}
