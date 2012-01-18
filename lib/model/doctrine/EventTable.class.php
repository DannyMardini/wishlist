<?php

/**
 * EventTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class EventTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object EventTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Event');
    }
    
    public function getUpcomingEvents($userId)
    {
        $q = $this->createQuery()->where('usera_id = ?', $user);

        $friendships = $q->execute();

        foreach ($friendships as $friendship)
        {
            $friend_ids[] = $friendship->getUserbId();
        }

        if($friend_ids)
        {
            return WishlistUserTable::getInstance()->createQuery('w')->whereIn('w.wishlistuser_id', $friend_ids)->execute();
        }        
    }
}