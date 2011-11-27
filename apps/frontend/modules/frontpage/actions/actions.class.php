<?php

/**
 * frontpage actions.
 *
 * @package    wishlist
 * @subpackage frontpage
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class frontpageActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeTest(sfWebRequest $request)
  {
  }

  public function executeProcess(sfWebRequest $request)
  {
      $lovestring = $request->getPostParameter('lovestring');
      $loveResponse = "I love you too";

      return $this->renderText($loveResponse);
  }

  public function executeIndex(sfWebRequest $request)
  {
      $this->showUserAdded = "yes";
      /*
      try
      {
          if($request->getParameter("submitRequestInvite"))
          {
              $this->executeRegister($request);                        
          }              
      }
      catch(Exception $e)
      {
          
      }
       * 
       */
  }
  
  public function executeRegister(sfWebRequest $request)
  {
      try
      {
          $email = $request->getParameter("email_addr");

          if( $email )
          {
              PendingUserTable::getInstance()->addPendingUser($email);
          }
      }
      catch(Exception $e)
      {
          $eMessage = "test";
      }
  }
  
  public function executeLogin(sfWebRequest $request)
  {
      $email = $request->getPostParameter("email_addr");
  }
}
