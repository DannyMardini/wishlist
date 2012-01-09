<?php

/**
 * wishlist_updateTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class wishlist_updateTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object wishlist_updateTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('wishlist_update');
    }
    
    public function getFriendsUpdates($userId)
    {                                           
        $q = Doctrine_Query::create() // concat(usr.firstname, ' ', usr.lastname) as subject,
                ->select("u.id, u.template, u.type, u.message, u.datetime, u.user_id, concat(usr.firstname,' ',usr.lastname)")
                ->from('wishlist_update u')
                ->leftJoin('u.WishlistUser usr') // ON u.user_id = wishlistuser_id')
                ->where('u.user_id IN ( select userb_id from friendships where usera_id = ?)',$userId)               
                ->orderBy('datetime desc');
        
        $t = $q->getSqlQuery();
       
        $updates = $q->execute();
        
        return $updates;
    }
}