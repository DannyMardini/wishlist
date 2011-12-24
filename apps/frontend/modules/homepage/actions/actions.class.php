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
    try {
      $email = $request->getPostParameter('email_addr');
      $pass = $request->getPostParameter('password');

      $this->user = WishlistUserTable::getInstance()->getUserWithEmail($email);

      if ($this->user->getPassword() != $pass)
      {
        throw new Exception('Incorrect password');
      }

      $_SESSION['user'] = $this->user->getEmail();
    }catch(Exception $e)
    {
      $e->getTrace();
    }
  }
}
