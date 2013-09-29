<link href="/css/shoppingList.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/shoppingList.js"></script>
<script type="text/javascript" src="/js/common.js"></script>

<div class="listHeader">     
    <?php $shoppinglistCount = count($purchases); ?>
    <label class="pageHeader" id="shoppinglist_count_<?php echo $shoppinglistCount ?>">Shopping List ( <?php echo $shoppinglistCount ?> )</label>    
    <button id='retractPurchaseButton' title='cancel selected item(s)' type='button'></button>
</div> 
<hr size="1" width="90%" color="grey">

<div id="shoppinglist">
    <?php
    $createDateLink = "<a href='#'>Set a gift date!</a>";
    
    foreach($purchases as $purchase)
    {
        $giftDate = $purchase->getGiftDate();
        $purchasedWishlistItem = $purchase->getItem();
        $purchasedItem = $purchasedWishlistItem->getItem();
        $giftUser = $purchasedWishlistItem->getWishlistUser();
        $giftId = $purchase->getId();
        $giftName = $purchasedItem->getName();

        echo "<div title='Click to select item' class='shoppinglistItem' id='".$giftId."'> ";
        echo "<input class='selectItem' type='checkbox' />";
        echo "<label>Item:</label><div class='name itemDetail' >".$giftName."</div>"; 
        echo "<label>For:</label><div class='itemDetail' >".$giftUser->getName()."</div>";
        echo "<label>Date Due:</label><div class='itemDetail'>".(isset($giftDate)? $giftDate->format('d/m/Y'):$createDateLink)."</div>";
        echo "</div>";
    }
    ?>
</div>
