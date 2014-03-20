<?php 
use Wishlist\CoreBundle\Entity\Item;

foreach ($view['assetic']->stylesheets(array('compass/stylesheets/wishlist.css', 'compass/stylesheets/main.css'), array('?yui_css')) as $url): ?>
<link rel="stylesheet" type="text/css" media="screen, projection" href="<?php echo $view->escape($url)."?rand=".rand() ?>" /><?php endforeach; ?>

<?php
//Helper functions
$i = count($wishlistItems);

echo "<h2 class='pageHeader'>Wishlist</h2>";
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


        $itemRow = "<tr><td><div class='itemContainer strong-label' onclick='".$wishItemDialog."'>";
        
        if( strlen($item->getSmallImage()) ) {
            $itemRow .= "<span class='imageContainer'><img class='itemImage' src=".$item->getSmallImage()." alt='Item Image'/></span>";
        }
        $itemRow .= "<div class='itemName item-link'>".$item->getName()."</div></div></td>"
                    ."<td>".$item->getPrice(Item::CURRENCY_UNIT_DOLLAR)."</td>"
                    ."<td>".$purchasedCell."</td>"
                    ."</tr>";
        echo $itemRow;
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

if(count($wishlistItems) <= 0 && ($selfWishlist))
{
    echo "<div class='jumbotron'>
              <h1><small>Friends see what you want by looking at your wish list</small></h1>
              <h3>Add items to your wish list...</h3>
              <p><span class='bullet-icon ui-icon ui-icon-carat-1-e'></span>Click the (+) button above<br />
              <span class='bullet-icon ui-icon ui-icon-carat-1-e'></span>Search for an item from online stores<br />
              <span class='bullet-icon ui-icon ui-icon-carat-1-e'></span>Or create your own item rather than searching online </p>
            </div>";
}
?>

