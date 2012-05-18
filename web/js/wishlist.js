/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var wishlist_div = "#div_wishlist_div";
var selected_itemId;

function setupWishlist()
{
    $(wishlist_div).accordion({
        collapsible: true,
        active: false
    });

    $(wishlist_div).keyup(function(e) {
        if(e.keyCode === 13 )
        {            
            e.preventDefault();
            var itemObj = {name: $("#newWishName").val(), price: $("#newWishPrice").val(), link: $("#newWishLink").val()};
            addToWishlist(itemObj, setupWishlist);
        }
    });

    $("h3 .ui-icon-close").click(function(e){
        $(wishlist_div).accordion( "option", "disabled", true);
        var itemObj = {name: $(this).next().text()};
        delFromWishlist(itemObj, setupWishlist);
    });
    
    $('.purchaseBtn').click(selectItem);

    $('#confirmDialog').dialog(
        {
            autoOpen: false,
            position: 'center',
            modal: true,
            open: confirmDialogOpen,
            close: confirmDialogClose
        }
    );
}

function selectItem()
{
    selected_itemId = $(this).attr('id');
    getItemInfo(selected_itemId, function(itemInfo){
        populateDialogItemInfo(itemInfo);
        $('#confirmDialog').dialog('open');
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

function confirmDialogOpen()
{
    //Set up purchase button
    $('#confirmBtn').click(function(){ 
        purchaseItem(selected_itemId);
        $('#confirmDialog').dialog('close');
    });
}

function populateDialogItemInfo(itemInfo)
{
    if( !itemInfo )
    {
        $('#confirmDialog').dialog('close');
        return;
    }
    
    var item = JSON.parse(itemInfo);
    
    $('#confirmName').html('<p>' + item.name + '</p>');
}

function confirmDialogClose()
{
    $('#confirmBtn').unbind('click');
}

$(document).ready(function(){
    setupWishlist();
});