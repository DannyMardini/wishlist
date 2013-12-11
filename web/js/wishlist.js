/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var wishlist_div = "#div_wishlist_div";

$(document).ready(function(){
    setupWishlist();
    checkGranted();
});

function setupWishlist()
{
    $('#wishlist_bs_table').tablecloth({
          theme: "default",
          striped: true,
          sortable: true,
          bordered: true
    }); 
    
    $('#addItemButton').button({
            icons: {
                primary: "ui-icon-plusthick"
            },
            text: false
    }).click(function(){
        e.preventDefault();
        //setupWishDialogView(null,{edit:"1", newItem:"1"});        
        $('#amazonSearchDialog').dialog('open');
    });
    
    $('#addItemButton').css('height', '25');
    
    $('.purchaseBtn').on('click', clickedItem);
}

function deleteLoadedItem()
{
        confirm("Are you sure you want to delete this wish?")
        .then(function (answer) {
            if(answer == 1)
            {
                var itemToDelete = $('#editItemDialog #name').val();
                var itemObj = {name: itemToDelete};
                delFromWishlist(itemObj, setupWishlist);
            }
        });       
}

function clickedItem()
{ // TODO: check why selected_itemId is overwritten later
    selected_itemId = $(this).attr('id');
    getItemInfo(selected_itemId, function(itemInfo){
        openAddToShoppingListDialog(itemInfo); 
    });
}

function getItemInfo(itemId, callBackFunc)
{
    $.ajax({
        type: 'POST',
        url: Routing.generate('WishlistCoreBundle_getItemInfo'),
        data: {id: itemId}
    }).success(function(data){
        if(data)
            callBackFunc(data);        
    });
}

function onUpdateWishItemClick(dialog){
    var wishlistUpdateItemPath = Routing.generate('WishlistListBundle_wishlistUpdate');

    // Ask them to confirm first
    confirm('Are you sure you want to save these changes?')
    .then(function(answer){
        if(answer == 1)
        {
            // pass the item to the backend and save the changes
            var item = getItemDialogObj(dialog);
            
            // pass the item to the backend
            submitTheWish(item, wishlistUpdateItemPath, onCompleteUpdateItemEvent, dialog);
        }
    });    
}

function onCompleteUpdateItemEvent(responseText, textStatus)
{
   switch(textStatus.toLowerCase())
    {
        case "success":
            setupWishlist();
            popupMessage('Yay!','The item has been updated!');
            break;
        default:
            popupMessage('Sorry!', 'The item could not be updated. Please try again later.');            
            break;       
    }    
}

function checkGranted()
{
    var grantedWishes = getIds($('#grantedWishes div'));
    if(grantedWishes.length > 0) {
        var message = 'Your wishes have been granted! The following items have been removed from your wishlist:';

        message += $('#grantedWishes').html();

        popupMessage('Wishes Granted', message, function() {
            var url = Routing.generate('WishlistListBundle_grantedItemNotified');
            ajaxPost({notifiedItems: grantedWishes}, url);
        });
    }
}
