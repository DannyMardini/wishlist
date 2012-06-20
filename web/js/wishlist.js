/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var wishlist_div = "#div_wishlist_div";
var selected_itemId = -1;
var selected_eventId = -1;

function isValidDate(year, month, day)
{
    var daysInMonth = function (y, m) {return 32-new Date(y, m, 32).getDate(); };
    
    if(year < 2000 || year > 3000)
        return false;
    
    if(month < 0 || month > 11)
        return false;
    
    if(day < 0 || day > daysInMonth(year, month))
        return false;
    
    return true;
}

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
    
    var month = parseInt(str_arr[0], 10);
    var day = parseInt(str_arr[1], 10);
    var year = parseInt(str_arr[2], 10);
    
    //This is quite stupid as monthValue is the only value that begins with an
    //index of zero, subtract one to fix it.
    month--;
    
    if(!isValidDate(year, month, day))
    {
        throw "Invalid date.";
    }
    
    retDate.setFullYear(year, month, day);

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

function clearEventHighlights()
{
    $('.confirmEvent').css('background-color', '');
}

function highlightEvent(selected)
{
    selected.css('background-color', '#999999');
}

function unselectEvent()
{
    clearEventHighlights();
    selected_eventId = -1;
}

function selectEvent(selected)
{
    var eventId = parseEventId(selected.attr('id'));
    
    if(eventId < 0)
        return;
    
    selected_eventId = eventId;
    clearEventHighlights();
    highlightEvent(selected)
}

function isSelectedEvent(selected)
{
    var eventId = parseEventId(selected.attr('id'));
    
    if( eventId == selected_eventId )
    {
        return true;
        
    }
    
    return false;
}

function toggleSelectEvent(selected)
{
    if( isSelectedEvent(selected) )
    {
        unselectEvent();
    }
    else 
    {
        selectEvent(selected);
    }
}

function clickedEvent()
{   
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
    try
    {
        var giftDate = parseDate($('#giftDateInput').attr('value'));
    
    
        if((selected_eventId > 0) && (giftDate == null)){
            purchaseItem(selected_itemId, selected_eventId, "Event");
        }
        else if((giftDate != null) && (selected_eventId < 0)){
            purchaseItem(selected_itemId, giftDate.toDateString(), "Date");
        }
        else {
            throw "Please select either an event or a date.";
        }
    }catch(e)
    {
        alert(e);
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
    unselectEvent();
    $('#confirmBtn').unbind('click');
}

$(document).ready(function(){
    setupWishlist();
});