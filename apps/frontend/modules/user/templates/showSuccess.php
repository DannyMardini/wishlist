<?php use_stylesheet('/css/userPage.css'); ?>
<?php use_javascript('/js/userPage.js'); ?>
<div id="div_user_container">
    <div id="div_profile_pic">
    </div>

    <div>
        <div id="div_user_info">
            <p>Name: <?php echo $wishlist_user->getName(); ?></p>
            <p>Gender: <?php echo $wishlist_user->getGender(); ?></p>
            <p>Age: <?php echo $wishlist_user->getAge(); ?></p>
            <p>Birth date: <?php echo $wishlist_user->getBirthdate(); ?></p>
            <p>Member since: <?php echo $wishlist_user->getCreatedAt(); ?></p>
        </div>
    </div>
</div>
<a href="<?php echo url_for('user/edit?wishlistuser_id='.$wishlist_user->getWishlistuserId()) ?>">Edit</a>
<a href="<?php echo url_for('user/index') ?>">List</a>
