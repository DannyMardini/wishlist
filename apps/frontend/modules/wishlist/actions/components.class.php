<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class newsComponents extends sfComponents
{
  public function executeHeadlines()
  {
    $c = new Criteria();
    $c->addDescendingOrderByColumn(NewsPeer::PUBLISHED_AT);
    $c->setLimit(5);
    $this->news = NewsPeer::doSelect($c);
  }
}
