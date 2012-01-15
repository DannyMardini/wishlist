<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class wishlistComponents extends sfComponents
{ 
  public function executeShowWishlist()
  {
    $user = WishlistUserTable::getInstance()->find(array($this->wishlistuser_id));
    $this->wishlist_user = $user->getEmail();
    $this->wishlist_items = $user->getWishlistItems();
  }
}

?>