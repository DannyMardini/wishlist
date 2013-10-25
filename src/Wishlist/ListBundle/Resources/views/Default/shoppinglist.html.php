<link href="/css/shoppingList.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/shoppingList.js"></script>
<script type="text/javascript" src="/js/common.js"></script>

<div class="listHeader">     
    <?php $shoppinglistCount = count($purchases); ?>
    <label class="pageHeader" id="shoppinglist_count_<?php echo $shoppinglistCount ?>">Shopping List ( <?php echo $shoppinglistCount ?> )</label>    
    <button class="removeButton" id='retractPurchaseButton' title='cancel selected item(s)' type='button'><span class='ui-icon ui-icon-minus'></span></button>
</div> 
<hr size="1" width="90%" color="grey">

<div id="shoppinglist">
    <?php
    $createDateLink = "<a href='#'>Set a gift date!</a>";
    
    echo "<table id='shoppingList_bs_table' class='shoppinglistItem'>
        <tr><th></th><th>Item</th><th>For</th><th>Date Due</th></tr>";
    
    foreach($purchases as $purchase)
    {
        $giftDate = $purchase->getGiftDate();
        $purchasedWishlistItem = $purchase->getItem();
        $purchasedItem = $purchasedWishlistItem->getItem();
        $giftUser = $purchasedWishlistItem->getWishlistUser();
        $giftId = $purchase->getId();
        $giftName = $purchasedItem->getName();
        
        echo "<tr><td><input id='".$giftId."' class='selectItem' type='checkbox' /></td>
            <td>".$giftName."</td>
            <td>".$giftUser->getName()."</td>
            <td>".(isset($giftDate)? $giftDate->format('d/m/Y'):$createDateLink)."</td>
            </tr>";
    }
    
    echo "</table>";
    ?>
</div>
