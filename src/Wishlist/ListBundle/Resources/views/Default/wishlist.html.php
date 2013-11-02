<link href="/css/wishlist.css" rel="stylesheet" type="text/css" />
<link href="/css/formStyling.css" rel="stylesheet" type="text/css" />

<?php
//Helper functions

$i = $wishlistItems->count();

echo "<label class='pageHeader'>Wishlist</label>";
if ($selfWishlist)
{    
    echo "<button class='addButton' title='add item' id='addItemButton'><span class='ui-icon ui-icon-plus'></span></button>";
}
echo "<span class='itemCountSpan'>".$i." Item(s)</span>";
echo "<hr size='1' width='100%' color='grey'> 
    <table id='wishlist_bs_table'>
    <thead><tr><th>Wish Item</th><th>Price</th><th>Promised by</th></tr></thead><tbody>";

while($i > 0)
{
    $currItem = $wishlistItems[$i-1];
    $item = $currItem->getItem();
    $itemId = $currItem->getId();
    $itemPurchased = $currItem->isPurchased();
    $itemPurchaser = $itemPurchased ? $currItem->getPurchase()->getWishlistUser() : null;
    $purchaserIsLoggedInUser = $itemPurchaser ? ($itemPurchaser->getWishlistuserId() == $loggedInUserId) : null;
    $purchasedCell = "";
    
    if($purchaserIsLoggedInUser) // Display a flag for the items you've promised to purchase
    {
        $purchasedCell = "You";
    } 
    else if($itemPurchased && !$selfWishlist) // The user can see when items are promised by other users
    {   
        $purchasedCell = $itemPurchaser->getName();
    }
    
    if ($selfWishlist) // When looking at your own wishlist...
    {
        // An item click opens a dialog that permits updates and deletions of the item
        $wishItemDialog = 'openWishDialog('.$itemId.',{edit:"1",newItem:"0"}, setupWishDialogView)';
    }
    else  // When looking at a friends wishlist...
    {  
        // An item click opens a dialog that permits granting the wish or adding the item to your own wishlist
        $wishItemDialog = 'openWishDialog('.$itemId.', {selfWishlist: "0"}, setupItemView)';
    }
    
    echo "<tr>
        <td><a href='#' onclick='".$wishItemDialog."'>".$item->getName()."</a></td>
        <td>".$item->getPrice()."</td>
        <td>".$purchasedCell."</td>
        </tr>";
    
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


<div id='editItemDialog' title='Edit Wish' >  
    <input type='hidden' id='itemId' /> 
    Name: <input disabled type='text' id='name' placeholder='Enter Name' />
    Price: <input disabled type='text' id='price' placeholder='Enter Price' />
    Link:  <input disabled type='text' id='link' placeholder='Enter Link' />
    Quantity: <input type='text' id='quantity' placeholder='Quantity (Default = 1)'/>
    Notes: <input type='text' id='notes' placeholder='Notes (Optional)'/>    
    <span style='display:inline-block;'>Keep this wish private:</span>
    <input style='width:25%;display:inline-block;' type='checkbox' id='isPrivate' />
    </span>
</div>
