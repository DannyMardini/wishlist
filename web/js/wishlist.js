/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var wishlist_div = "#div_wishlist_div";
var selected_itemId;
var selected_eventId;

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
    $('.confirmEvent').click(selectEvent);

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

function parseEventId(idString)
{
    var split_str = idString.split('_');
    
    if(split_str.length != 2)
        return -1;  //Return an invalid event id if we couldn't parse
    
    return parseInt(split_str[1]);
}

function selectEvent()
{
    selected_eventId = parseEventId($(this).attr('id'));
    
    //Make sure only the selected event is highlighted.
    $('.confirmEvent').css('background-color', '');
    $(this).css('background-color', '#999999');
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
        purchaseItem(selected_itemId, selected_eventId);
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
    
    $('#confirmName').html(item.name);
}

function confirmDialogClose()
{
    $('#confirmBtn').unbind('click');
}

$(document).ready(function(){
    setupWishlist();
});