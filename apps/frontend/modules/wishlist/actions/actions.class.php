<?php

/**
 * wishlist actions.
 *
 * @package    wishlist
 * @subpackage wishlist
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class wishlistActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeShow(sfWebRequest $request)
  {
    $this->wishlist_user = Doctrine_Core::getTable('WishlistUser')->find(array($request->getParameter('wishlistuser_id')));
    $this->forward404Unless($this->wishlist_user);

    $this->wishlist_items = $this->wishlist_user->getWishlistItems();
  }
}
