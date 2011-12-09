<?php
use_stylesheet('/css/wishlist.css');
use_javascript('/js/wishlist.js');

include_component('wishlist', 'showWishlist', array('wishlist_items' => $wishlist_items));
?>