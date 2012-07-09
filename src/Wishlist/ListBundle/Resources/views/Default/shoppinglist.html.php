<link href="/css/shoppingList.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/shoppingList.js"></script>

<div id="div_shoppinglist_div">
    <table>
    <?php 
    foreach($purchases as $purchase)
    {
        $giftDate = $purchase->getGiftDate();
        $purchasedItem = $purchase->getItem();
        $giftUser = $purchasedItem->getWishlistUser();

        echo "<tr id='".$purchasedItem->getId()."'>";
        echo "<td>".$purchasedItem->getName()."</td>";
        echo "<td>".$giftUser->getFirstname()." ".$giftUser->getLastname()."</td>";
        echo "<td>".(isset($giftDate)? $giftDate->format('Y-m-d'):"")."</td>";
        echo "<td><input type='checkbox'/></td>";
        echo "</tr>";
    }
    ?>
    </table>
    <button type='button'>Apply</button>
</div>