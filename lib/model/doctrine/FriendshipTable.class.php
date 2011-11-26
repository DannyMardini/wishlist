<?php

/**
 * FriendshipTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class FriendshipTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object FriendshipTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Friendship');
    }

    public function getFriendsOf($user)
    {
        $q = $this->createQuery()
                ->where('usera_id = ?', $user);

        $friendships = $q->execute();

        foreach ($friendships as $friendship)
        {
            $friend_ids[] = $friendship->getUserbId();
        }

        return WishlistUserTable::getInstance()->createQuery('w')->whereIn('w.wishlistuser_id', $friend_ids)->execute();
    }
}