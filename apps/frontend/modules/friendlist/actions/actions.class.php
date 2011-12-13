<?php

/**
 * friendlist actions.
 *
 * @package    wishlist
 * @subpackage friendlist
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class friendlistActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
      //$this->friends = FriendshipTable::getInstance()->getFriendsOf($request->getPostParameter('username'));
      $this->forward404Unless($wishlist_user = WishlistUserTable::getInstance()->find($request->getParameter('wishlistuser_id')));

      $this->user = $wishlist_user->getFirstname();
      $this->friends = FriendshipTable::getInstance()->getFriendsOf($request->getParameter('wishlistuser_id'));
  }
}
