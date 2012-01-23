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
    $email = $request->getPostParameter('email_addr');
    $this->forward404Unless($email);

    $pass = $request->getPostParameter('password');

    try {
      $this->user = WishlistUserTable::getInstance()->getUserWithEmail($email);

      if ($this->user->getPassword() != $pass)
      {
        throw new Exception('Incorrect password');
      }

      $_SESSION['user'] = $this->user->getEmail();
      $this->friendUpdates = WishlistUpdateTable::getInstance()->GetFriendsUpdates($this->user->getWishlistuser_id());
    }catch(Exception $e)
    {
      $e->getTrace();
    }
  }
  
  public function executeGetUpcomingEvents(sfWebRequest $request)
  {
      $userId = $request->getParameter('wishlistuser_id');
      $events = EventTable::getInstance()->getUpcomingEvents($userId);
      $test = '{"bindings": [{"ircEvent": "PRIVMSG"},{"ircEvent": "PRIVMSG"},{"ircEvent": "PRIVMSG"}]}'; 
      return $this->renderText($events); 
  }
}
