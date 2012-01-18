<?php

/**
 * navBar actions.
 *
 * @package    wishlist
 * @subpackage navBar
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class navBarActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  }

  public function executeLogout(sfWebRequest $request)
  {
      session_unset();
      session_destroy();
      $this->forward('frontpage', 'index');
  }
}
