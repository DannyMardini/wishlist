<link href="<?php echo $view['assets']->getUrl('compass/stylesheets/wishlist.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />

<?php
//Helper functions
$i = count($wishlistItems);

echo "<label class='pageHeader'>Wishlist</label>";
if ($selfWishlist)
{    
    echo "<button class='addButton' title='add item' id='addItemButton'><span class='ui-icon ui-icon-plus'></span></button>";
}
echo "<span class='itemCountSpan'>".$i." Item(s)</span>";
echo "<hr size='1' width='100%' color='grey'> ";

if($i > 0){
    echo "<table id='wishlist_bs_table'>
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

    echo "</tbody></table>\n";
}

if(isset($nonNotifiedGranted))
{
    echo "<div id='grantedWishes' style='display: none'>\n";
    foreach($nonNotifiedGranted as $granted)
    {
        echo "<div id='".$granted->getId()."'>".$granted->getItem()->getName()."</div>\n";
    }
    echo "</div>\n";
}

if(count($wishlistItems) <= 0)
{
    echo "<div class='message'> Your list is empty! In order for your friends to see what YOU WANT, start adding items to your list! <br /><br />
        Click the (+) button above to add your first item.<br /><br /></div>";
}
?>

