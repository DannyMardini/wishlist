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
    $this->user_id = $request->getParameter('wishlistuser_id');
  }

  public function executeNew(sfWebRequest $request)
  {
    $user = WishlistUserTable::getInstance()->getUserWithEmail($_SESSION['user']);
    $name = $request->getPostParameter('newWishName');
    $price = $request->getPostParameter('newWishPrice');
    $link = $request->getPostParameter('newWishLink');

    if( !isset ($name) || !isset ($price) || !isset ($link))
      return;

    $newItem = new WishlistItem();
    $newItem->setName($name);
    $newItem->setPrice($price);
    $newItem->setLink($link);
    $newItem->setUserId($user->getWishlistuserId());
    $newItem->save();
  }
}
