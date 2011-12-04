<?php

/**
 * user actions.
 *
 * @package    wishlist
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->wishlist_users = Doctrine_Core::getTable('WishlistUser')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->wishlist_user = Doctrine_Core::getTable('WishlistUser')->find(array($request->getParameter('wishlistuser_id')));
    $this->forward404Unless($this->wishlist_user);

    $this->wishlist_items = $this->wishlist_user->getWishlistItems();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new WishlistUserForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new WishlistUserForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($wishlist_user = Doctrine_Core::getTable('WishlistUser')->find(array($request->getParameter('wishlistuser_id'))), sprintf('Object wishlist_user does not exist (%s).', $request->getParameter('wishlistuser_id')));
    $this->form = new WishlistUserForm($wishlist_user);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($wishlist_user = Doctrine_Core::getTable('WishlistUser')->find(array($request->getParameter('wishlistuser_id'))), sprintf('Object wishlist_user does not exist (%s).', $request->getParameter('wishlistuser_id')));
    $this->form = new WishlistUserForm($wishlist_user);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($wishlist_user = Doctrine_Core::getTable('WishlistUser')->find(array($request->getParameter('wishlistuser_id'))), sprintf('Object wishlist_user does not exist (%s).', $request->getParameter('wishlistuser_id')));
    $wishlist_user->delete();

    $this->redirect('user/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $wishlist_user = $form->save();

      $this->redirect('user/edit?wishlistuser_id='.$wishlist_user->getWishlistuserId());
    }
  }
}
