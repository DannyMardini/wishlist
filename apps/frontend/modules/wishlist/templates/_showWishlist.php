<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div id="div_wishlist_div">
  <h3><a id="newWishBox" href="#">New wish..</a></h3>
  <div class="newWishBox">
      <input type="text" id="newWishName" placeholder="Name"/>
      <input type="text" id="newWishPrice" placeholder="Price"/>
      <input type="text" id="newWishLink" placeholder="Link"/>
  </div>
<?php 
  //foreach ($wishlist_items as $wishlist_item):
  for($i = ($wishlist_items->count()-1); $i >= 0; $i--):
?>
    <h3><a href="#"><?php echo $wishlist_items[$i]->getName(); ?></a></h3>
    <div>
        <p><?php echo "$".$wishlist_items[$i]->getPrice(); ?></p>
    </div>
<?php
  endfor;
////endforeach;
?>
</div>
