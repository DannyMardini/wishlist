<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div id="div_wishlist_div">
<?php
    if($_SESSION['user'] == $wishlist_user_email)
    {
        echo "<h3><a id='newWishBox' href='#'>New wish..</a></h3>";
        echo "<div class='newWishBox'>";
        echo "    <input type='text' id='newWishName' placeholder='Name'/>";
        echo "    <input type='text' id='newWishPrice' placeholder='Price'/>";
        echo "    <input type='text' id='newWishLink' placeholder='Link'/>";
        echo "</div>";
    }
    for($i = ($wishlist_items->count()-1); $i >= 0; $i--):
?>
    <h3><span class="ui-icon ui-icon-close"></span><a href="#"><?php echo $wishlist_items[$i]->getName(); ?></a></h3>
    <div>
        <p><?php echo "$".$wishlist_items[$i]->getPrice(); ?></p>
    </div>
<?php
  endfor;
?>
</div>
