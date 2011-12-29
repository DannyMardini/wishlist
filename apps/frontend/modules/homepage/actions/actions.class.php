<?php

/**
 * homepage actions.
 *
 * @package    wishlist
 * @subpackage homepage
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class homepageActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
   $this->username = $request->getParameter('wishlistuser_firstname');
   $this->id = $request->getParameter('wishlistuser_id');
   
   // grab updates of this users friends
   $this->friendUpdates = UpdatesTable::getInstance()->GetFriendsUpdates($this->id);                       
  }
  
}
