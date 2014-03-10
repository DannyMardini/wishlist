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
            <tr><th>&nbsp;</th><th>Item</th><th>For</th><th>Date Due</th></tr>";

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
                <td><a class='strong-label item-link' onclick='openLink(&#39;".$giftLink."&#39;)' target='_blank'>".$giftName."</a></td>
                <td>".$giftUser->getName()."</td>
                <td>".$dateDisplay."</td>
                </tr>";
        }

        echo "</table>";
    }
    else {
        echo "<div class='jumbotron'>
              <h1><small>The shopping list helps you track what you need to buy and for who</small></h1>
              <h3>Add items to your shopping list...</h3>
              <p><span class='bullet-icon ui-icon ui-icon-carat-1-e'></span>Browse your friends' wish lists to see what they want <br />
              <span class='bullet-icon ui-icon ui-icon-carat-1-e'></span>Choose an item that you would like to give to your friend<br />
              <span class='bullet-icon ui-icon ui-icon-carat-1-e'></span>Click 'Grant Wish' to promise to get the item for your friend<br />
              <span class='bullet-icon ui-icon ui-icon-carat-1-e'></span>The item will now show up on your shopping list
              </p>
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
