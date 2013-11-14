/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var wishlist_div = "#div_wishlist_div";

$(document).ready(function(){
    setupWishlist();
});

function setupWishlist()
{
    $('#wishlist_bs_table').tablecloth({
          theme: "default",
          striped: true,
          sortable: true,
          bordered: true
    }); 

    $('#addItemButton').click(function(e){
        e.preventDefault();
        setupWishDialogView(null,{edit:"1", newItem:"1"});
    });
    
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
        url: '/app_dev.php/ItemInfo',
        data: {id: itemId}
    }).success(function(data){
        if(data)
            callBackFunc(data);        
    });
}

function onUpdateWishItemClick(dialog){
    // Ask them to confirm first
    confirm('Are you sure you want to save these changes?')
    .then(function(answer){
        if(answer == 1)
        {
            // pass the item to the backend and save the changes
            var item = getItemDialogObj(dialog);
            
            // pass the item to the backend
            submitTheWish(item, wishlistUpdateItemPath, onCompleteUpdateItemEvent);
            
            // todo: I think it would make sense to reload the wishlist afterwards... 
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
            location.reload();
            break;       
    }    
}

