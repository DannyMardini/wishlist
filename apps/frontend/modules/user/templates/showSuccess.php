<?php use_stylesheet('/css/userPage.css'); ?>

<div id="div_profile_pic">
</div>

<div id="div_user_info">
    <p>Name: <?php echo $wishlist_user->getName(); ?></p>
    <p>Gender: <?php echo $wishlist_user->getGender(); ?></p>
    <p>Age: <?php echo $wishlist_user->getAge(); ?></p>
    <p>Birth date: <?php echo $wishlist_user->getBirthdate(); ?></p>
    <p>Member since: <?php echo $wishlist_user->getCreatedAt(); ?></p>
</div>

<table>
  <tbody>
    <tr>
      <th>Name:</th>
      <td><?php echo $wishlist_user->getName() ?></td>
    </tr>
    <tr>
      <th>Gender:</th>
      <td><?php echo $wishlist_user->getGender() ?></td>
    </tr>
    <tr>
      <th>Birthdate:</th>
      <td><?php echo $wishlist_user->getBirthdate() ?></td>
    </tr>
    <tr>
      <th>Email:</th>
      <td><?php echo $wishlist_user->getEmail() ?></td>
    </tr>
    <tr>
      <th>Wishlistuser:</th>
      <td><?php echo $wishlist_user->getWishlistuserId() ?></td>
    </tr>
    <tr>
      <th>Created at:</th>
      <td><?php echo $wishlist_user->getCreatedAt() ?></td>
    </tr>
    <tr>
      <th>Updated at:</th>
      <td><?php echo $wishlist_user->getUpdatedAt() ?></td>
    </tr>
  </tbody>
</table>

<hr />

<a href="<?php echo url_for('user/edit?wishlistuser_id='.$wishlist_user->getWishlistuserId()) ?>">Edit</a>
&nbsp;
<a href="<?php echo url_for('user/index') ?>">List</a>
