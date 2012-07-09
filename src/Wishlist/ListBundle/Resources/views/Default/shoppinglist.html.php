<link href="/css/shoppingList.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/shoppingList.js"></script>

<div id="div_shoppinglist_div">
    <table>
    <?php 
    foreach($purchasedItems as $purchasedItem)
    {
        $giftUser = $purchasedItem->getWishlistUser();
        echo "<tr id='".$purchasedItem->getId()."'>";
        echo "<td>".$purchasedItem->getName()."</td>";
        echo "<td>".$giftUser->getFirstname()." ".$giftUser->getLastname()."</td>";
        echo "<td><input type='checkbox'/></td>";
        echo "</tr>";
    }
    ?>
    </table>
    <button type='button'>Apply</button>
</div>