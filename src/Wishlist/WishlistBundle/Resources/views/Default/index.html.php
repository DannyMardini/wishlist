<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

 $self = ( $loggedInUserEmail == $wishlistUserEmail);

?>

<div id="div_wishlist_div">
<?php
    if($self)
    {
        echo "<h3><a id='newWishBox' href='#'>New wish..</a></h3>";
        echo "<div class='newWishBox'>";
        echo "    <input type='text' id='newWishName' placeholder='Name'/>";
        echo "    <input type='text' id='newWishPrice' placeholder='Price'/>";
        echo "    <input type='text' id='newWishLink' placeholder='Link'/>";
        echo "</div>";
    }
    
    for($i = ($wishlistItems->count()-1); $i >= 0; $i--)
    {
        echo "<h3>";
        if($self) {
            echo "<span class='ui-icon ui-icon-close'></span>";
        }

        echo "<a href='#'>".$wishlistItems[$i]->getName()."</a></h3>";
        echo "<div><p>$".$wishlistItems[$i]->getPrice()."</p></div>";
    }
?>

</div>
