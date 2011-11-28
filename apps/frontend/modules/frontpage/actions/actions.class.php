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
  }
  
  public function executeRequestInvite(sfWebRequest $request)
  {
      try
      {
          $email = $request->getPostParameter("email");

          if( $email )
          {
              PendingUserTable::getInstance()->addPendingUser($email);   
              $response = "Success";            
          }
          else
          {
              $response = "Error: email address is blank";
          }   
          
          return $this->renderText($response);
      }
      catch(Exception $e)
      {
          return $this->renderText("Error: Issue saving to database");
      }
  }
  
  public function executeLogin(sfWebRequest $request)
  {
      $email = $request->getPostParameter("email_addr");
  }
}
