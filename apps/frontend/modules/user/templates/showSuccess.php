<?php use_stylesheet('/css/userPage.css'); ?>
<?php use_javascript('/js/userPage.js'); ?>
<div id="div_user_container">
    <div id="div_profile_pic">
    </div>

    <div id="div_user_info">
        <p>Name: <?php echo $wishlist_user->getFirstname()." ".$wishlist_user->getLastname(); ?></p>
        <p>Gender: <?php echo $wishlist_user->getGenderString(); ?></p>
        <p>Age: <?php echo $wishlist_user->getAge(); ?></p>
    </div>
</div>

<div id="div_right_panel">
    <h1>Wishlist</h1>
    <div id="div_wishlist_div">
    <?php foreach ($wishlist_items as $wishlist_item): ?>
        <h3><a href="#"><?php echo $wishlist_item->getName(); ?></a></h3>
        <div>
            <p><?php echo "$".$wishlist_item->getPrice(); ?></p>
        </div>
    <?php        endforeach;?>
    </div>
</div>

<!--<a href="<?php echo url_for('user/edit?wishlistuser_id='.$wishlist_user->getWishlistuserId()) ?>">Edit</a>-->
<!--<a href="<?php echo url_for('user/index') ?>">List</a>-->
