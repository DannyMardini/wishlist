<?php
//Helper functions

$i = $wishlistItems->count();

echo "<label class='pageHeader'>Wishlist ( ".$i." )</label>";
    if ($selfWishlist)
    {    
        echo "<button title='add item' id='addItemButton'><span class='ui-icon ui-icon-plus'></span></button>";
    }
    echo "<hr size='1' width='100%' color='grey'> 
    <table id='wishlist_bs_table'>
    <thead><tr><th>Wish Item</th><th>Price</th><th>Promised by</th></tr></thead><tbody>";
    
while($i > 0)
{
    $currItem = $wishlistItems[$i-1];
    $item = $currItem->getItem();
    $purchasedCell = "";
    
    if ($selfWishlist)
    {
        //Only see the items that you purchased for yourself.
        if( $currItem->isPurchased() && ($currItem->getPurchaser() == $user) )
        {
            $purchasedCell = "Yourself";
        }
    }
    else
    {
        //See the items that others plan to purchase
        if($currItem->isPurchased())
        {   
            $purchaser = $currItem->getPurchase()->getWishlistUser();
            $purchasedCell = $purchaser->getName();
        }         
    }
    
    echo "<tr><td><a href='#' onclick='openWishDialog(".$currItem->getId().",".$selfWishlist.",0)'>".$item->getName()."</a></td>
        <td>".$item->getPrice()."</td><td>".$purchasedCell."</td></tr>";
    
    $i--;
}

echo "</tbody></table>";
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
