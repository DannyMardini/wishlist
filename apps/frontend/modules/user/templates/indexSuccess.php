<h1>Wishlist users List</h1>

<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Gender</th>
      <th>Birthdate</th>
      <th>Email</th>
      <th>Wishlistuser</th>
      <th>Created at</th>
      <th>Updated at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($wishlist_users as $wishlist_user): ?>
    <tr>
      <td><?php echo $wishlist_user->getName() ?></td>
      <td><?php echo $wishlist_user->getGender() ?></td>
      <td><?php echo $wishlist_user->getBirthdate() ?></td>
      <td><?php echo $wishlist_user->getEmail() ?></td>
      <td><a href="<?php echo url_for('user/show?wishlistuser_id='.$wishlist_user->getWishlistuserId()) ?>"><?php echo $wishlist_user->getWishlistuserId() ?></a></td>
      <td><?php echo $wishlist_user->getCreatedAt() ?></td>
      <td><?php echo $wishlist_user->getUpdatedAt() ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

  <a href="<?php echo url_for('user/new') ?>">New</a>
