<?php foreach ($view['assetic']->javascripts(array('js/shoppingList.js'), array('?yui_js')) as $url): ?>
<script src="<?php echo $view->escape($url)."?rand=".rand() ?>"></script><?php endforeach; ?>
<?php foreach ($view['assetic']->stylesheets(array('compass/stylesheets/shoppingList.css', 'compass/stylesheets/main.css'), array('?yui_css')) as $url): ?>
<link rel="stylesheet" type="text/css" media="screen, projection" href="<?php echo $view->escape($url)."?rand=".rand() ?>" /><?php endforeach; ?>

<div class="pageTitle">     
    <?php $shoppinglistCount = count($purchases); ?>
    <label class="pageHeader" id="shoppinglist_count_<?php echo $shoppinglistCount ?>">Shopping List </label>    
    <button class="removeButton" id='retractPurchaseButton' title='cancel selected item(s)' type='button'><span class='ui-icon ui-icon-minus'></span></button>
    <span class="itemCountSpan"><?php echo $shoppinglistCount ?> Item(s)</span>   
</div> 
<hr size="1" width="90%" color="grey">

<div id="shoppinglist">
    <?php
    if(count($purchases) > 0){
        echo "<table id='shoppingList_bs_table' class='shoppinglistItem'>
            <tr><th>Select</th><th>Item</th><th>For</th><th>Date Due</th></tr>";

        foreach($purchases as $purchase)
        {
            $giftDate = $purchase->getGiftDate();
            $event = $purchase->getEvent();

            if(isset($giftDate)) {
                $dateDisplay = $giftDate->format('F jS');
            }
            else {
                $dateDisplay = $event->getEventDate()->format('F jS');
            }

            $purchasedWishlistItem = $purchase->getItem();
            $purchasedItem = $purchasedWishlistItem->getItem();
            $giftUser = $purchasedWishlistItem->getWishlistUser();
            $giftId = $purchase->getId();
            $giftName = $purchasedItem->getName();
            $giftLink = $purchasedItem->getLink();

            echo "<tr><td><input id='".$giftId."' class='selectItem' type='checkbox' /></td>
                <td><a class='strong-label' href='".$giftLink."' target='_blank'>".$giftName."</a></td>
                <td>".$giftUser->getName()."</td>
                <td>".$dateDisplay."</td>
                </tr>";
        }

        echo "</table>";
    }
    else {
        echo "<div class='message'>Your shopping list is empty! Browse your friends wishlists to see what they want. <br /><br />
            1. Find an item on your friends wishlist <br />
            2. Click 'Grant Wish' <br />
            3. The item will then show up in your shopping list<br /><br />
            This list should help you track what you need to buy and for who!
            </div>";
    }
    ?>
</div>

<?php
    if(isset($expiredPurchases))
    {
        echo "<div id='expiredPurchases' style='display: none'>\n";
        foreach($expiredPurchases as $purchase)
        {
            echo "<div id='".$purchase->getId()."'>".$purchase->getItem()->getItem()->getName()."</div>\n";
        }
        echo "</div>\n";
    } 
?>
