<?php
//Helper functions
function wishlistItemHeader(/*Boolean*/$selfWishlist, /*WishlistItem*/$currItem, /*WishlistUser*/$wishlistUser)
{
    $classes = "";
    $showPurchased = false;
    
    if ($selfWishlist)
    {
        //Only see the items that you purchased for yourself.
        if( $currItem->isPurchased() && ($currItem->getPurchaser() == $wishlistUser) )
            $showPurchased = true;
    }
    else
    {
        //See the items that anyone purchased.
        if($currItem->isPurchased())
            $showPurchased = true;
    }
    
    if($showPurchased == true)
    {
        $classes = " class='purchased'";
    }
    
    $header = "<h3 id='".$currItem->getId()."'".$classes.">";
    
    return $header;
}

//HTML processing
echo "<div id='div_wishlist_div'>";
    if($selfWishlist)
    {
        echo "<h3><a id='newWishBox' href='#'>New wish..</a></h3>";
        echo "<div class='newWishBox'>";
        echo "    <input type='text' id='newWishName' placeholder='Name'/>";
        echo "    <input type='text' id='newWishPrice' placeholder='Price'/>";
        echo "    <input type='text' id='newWishLink' placeholder='Link'/>";
        echo "    <input type='text' id='newWishNotes' placeholder='Notes (Optional)'/>";
        echo "    <input type='text' id='newWishQuantity' placeholder='Quantity (Default = 1)'/>";
        echo "    <input type='submit' id='submitNewWish' name='Save' />";
        echo "</div>";
    }
    
    $i = $wishlistItems->count();
    
    while($i > 0)
    {
        $currItem = $wishlistItems[$i-1];

        
        echo wishlistItemHeader($selfWishlist, $currItem, $user);
        
        if($selfWishlist) {
            echo "<span class='ui-icon ui-icon-close'></span>";
        }

        echo "<a href='#'>".$currItem->getName()."</a></h3>";
        echo "<div>";
        echo "<p>$".$currItem->getPrice()."</p>";
        
        //TODO: This really should use the new HTML 5 
        echo "<span id='".$currItem->getId()."' class='purchaseBtn'>Purchase!</span>";
        
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
