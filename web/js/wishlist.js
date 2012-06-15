/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var wishlist_div = "#div_wishlist_div";
var selected_itemId = -1;
var selected_eventId = -1;

function parseDate(/*string*/ str)
{
    var retDate = new Date();
    
    if(str == ""){
        //string is not defined
        return null;
    }
    
    var str_arr = str.split("/");
    
    if( str_arr.length != 3 ){
        throw "Invalid date.";
    }
    
    retDate.setFullYear(str_arr[2], str_arr[0], str_arr[1]);

    /*
     * TODO:
     * FIx purchaseItem function to also accept a date.
     * Finish the rest of this parseDate function.
     */
    
    return retDate;
}

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
    
    $('.purchaseBtn').click(clickedItem);
    $('.confirmEvent').click(clickedEvent);

    $('#confirmDialog').dialog(
        {
            autoOpen: false,
            position: 'center',
            modal: true,
            open: confirmDialogOpen,
            close: confirmDialogClose
        }
    );
    
    $('#giftDateInput').datepicker();
}

function clickedItem()
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

function toggleSelectEvent(selected)
{
    var eventId = parseEventId(selected.attr('id'));
    
    if(eventId < 0)
        return;
    
    if(selected_eventId == eventId){
        //unselect the event
        selected_eventId = -1
    }
    else {
        selected_eventId = eventId;
        selected.css('background-color', '#999999');
    }
}

function clickedEvent()
{   
    //Make sure only the selected event is highlighted.
    $('.confirmEvent').css('background-color', '');
    toggleSelectEvent($(this));
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

function confirmOK()
{
    var giftDate = parseDate($('#giftDateInput').attr('value'));
    
    if((selected_eventId > 0) && (giftDate == null)){
        purchaseItem(selected_itemId, selected_eventId, "Event");
    }
    else if((giftDate != null) && (selected_eventId < 0)){
        purchaseItem(selected_itemId, giftDate.toDateString(), "Date");
    }
    else {
        alert("Please select either an event or a date.");
        return;
    }
        
    $('#confirmDialog').dialog('close');
}

function confirmDialogOpen()
{
    //Give the confirm button focus.
    $('#confirmBtn').focus();
    
    //Set up purchase button
    $('#confirmBtn').click(confirmOK);
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