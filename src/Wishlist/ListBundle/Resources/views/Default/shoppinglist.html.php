<link href="/css/shoppingList.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/shoppingList.js"></script>

<div id="div_shoppinglist_div">
    <table>
    <?php
    $createDateLink = "<a href='#'>New Giftdate!</a>";
    
    foreach($purchases as $purchase)
    {
        $giftDate = $purchase->getGiftDate();
        $purchasedWishlistItem = $purchase->getItem();
        $purchasedItem = $purchasedWishlistItem->getItem();
        $giftUser = $purchasedWishlistItem->getWishlistUser();

        echo "<tr id='".$purchase->getId()."'>";
        echo "<td>".$purchasedItem->getName()."</td>";
        echo "<td>".$giftUser->getFirstname()." ".$giftUser->getLastname()."</td>";
        echo "<td>".(isset($giftDate)? $giftDate->format('d/m/Y'):$createDateLink)."</td>";
        echo "<td><input type='checkbox'/></td>";
        echo "</tr>";
    }
    ?>
    </table>
    <button id='retractPurchaseButton' type='button'>Cancel purchases</button>
</div>