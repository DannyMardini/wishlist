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
    
    for($i = ($wishlistItems->count()-1); $i >= 0; $i--)
    {
        $currItem = $wishlistItems[$i];
        
        echo "<h3>";
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
    <div id="confirmCreateEvent">Create a new Event!</div>
    <span id="confirmBtn">Ok</span>
</div>
