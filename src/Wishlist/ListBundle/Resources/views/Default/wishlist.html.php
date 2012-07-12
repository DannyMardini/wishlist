<div id="div_wishlist_div">
<?php
    if($selfWishlist)
    {
        echo "<h3><a id='newWishBox' href='#'>New wish..</a></h3>";
        echo "<div class='newWishBox'>";
        echo "    <input type='text' id='newWishName' placeholder='Name'/>";
        echo "    <input type='text' id='newWishPrice' placeholder='Price'/>";
        echo "    <input type='text' id='newWishLink' placeholder='Link'/>";
        echo "</div>";
    }
    
    $i = $wishlistItems->count();
    
    while($i > 0)
    {
        $currItem = $wishlistItems[$i-1];
        
        //Add a purchased class to purchased wishlist items.
        if( !$selfWishlist && $currItem->isPurchased() )
        {
            echo "<h3 id='".$currItem->getId()."' class='purchased'>";
        }else {
            echo "<h3 id='".$currItem->getId()."'>";
        }
        
        
        if($selfWishlist) {
            echo "<span class='ui-icon ui-icon-close'></span>";
        }

        echo "<a href='#'>".$currItem->getName()."</a></h3>";
        echo "<div>";
        echo "<p>$".$currItem->getPrice()."</p>";
        if(!$selfWishlist)
        {
            //TODO: This really should use the new HTML 5 
            echo "<span id='".$currItem->getId()."' class='purchaseBtn'>Purchase!</span>";
        }
        echo "</div>";
        $i--;
    }
?>

</div>

<div id="confirmDialog" title="Purchase">
    <p>Purchase <span id="confirmName">Name</span> for event:</p>
    <div id="confirmEventContainer">
    <?php 
    if(isset($events))
    {
        foreach ($events as $event){
            echo "<div id='event_".$event->getId()."' class='confirmEvent'>".$event->getName()."</div>\n";
        }
    }
    ?>
    </div>
    <div id="confirmCreateEvent"><p>or enter a date!</p><input id="giftDateInput" type="text" tabindex="-1" placeholder="mm/dd/yyyy"/></div>
    <span id="confirmBtn">Ok</span>
</div>
