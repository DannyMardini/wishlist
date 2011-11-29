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
      $htmlFormattedMessage = "<p><span class='ui-icon ui-icon-circle-check' style='float:left; margin:0 7px 50px 0;'></span> [messageInputHere].</p>";
      
      try
      {
          $email = $request->getPostParameter("email");

          if( $email )
          {
              PendingUserTable::getInstance()->addPendingUser($email);
              $response = "Thanks! An invite will be sent to you shortly. <br /><br />-Wishlist Team"; 
          }
          else
          {
              $response = "Sorry about this! we could not read your email address. Please refresh your browser and try again. <br /><br />-Wishlist Team";
          }   
                    
          return $this->renderText(str_replace($htmlFormattedMessage, "[messageInputHere]", $response));
      }
      catch(Doctrine_Connection_Mysql_Exception $e)
      {
          return $this->renderText(str_replace($htmlFormattedMessage, "[messageInputHere]", "A request has already been submitted with your email address. You should receive an invite shortly. <br /><br />-Wishlist Team"));
      }
      catch(Exception $e)
      {
          $email = $email == null ? " no email " : $email;
          $errMessage = str_replace($htmlFormattedMessage, "[messageInputHere]", "Sorry about this! an issue occurred while submitting your email address. If you do not receive an invite by tomorrow please try again. <br /><br />-Wishlist Team");
          mail('dannymardini@gmail.com', 'Wishlist Error: could not add email to pendingUserTable', $errMessage + " email:" + $email);
          return $this->renderText($errMessage);
      }
  }
  
  public function executeLogin(sfWebRequest $request)
  {
      $email = $request->getPostParameter("email_addr");
  }
}
