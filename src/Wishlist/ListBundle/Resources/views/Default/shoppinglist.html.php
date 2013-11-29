<link href="<?php echo $view['assets']->getUrl('compass/stylesheets/shoppingList.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/shoppingList.js"></script>

<div class="pageTitle">     
    <?php $shoppinglistCount = count($purchases); ?>
    <label class="pageHeader" id="shoppinglist_count_<?php echo $shoppinglistCount ?>">Shopping List </label>    
    <button class="removeButton" id='retractPurchaseButton' title='cancel selected item(s)' type='button'><span class='ui-icon ui-icon-minus'></span></button>
    <span class="itemCountSpan"><?php echo $shoppinglistCount ?> Item(s)</span>   
</div> 
<hr size="1" width="90%" color="grey">

<div id="shoppinglist">
    <?php
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
        
        echo "<tr><td><input id='".$giftId."' class='selectItem' type='checkbox' /></td>
            <td>".$giftName."</td>
            <td>".$giftUser->getName()."</td>
            <td>".$dateDisplay."</td>
            </tr>";
    }
    
    echo "</table>";
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
