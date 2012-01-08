<?php


class navBarComponents extends sfComponents
{
  public function executeShowNavBar()
  {
    $this->friends = FriendshipTable::getInstance()->getFriendsOf($this->user_id);
  }
}

?>
