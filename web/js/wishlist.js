/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var wishlist_div = "#div_wishlist_div";
var selected_itemId = -1;
var selected_eventId = -1;

function setupEvents()
{
    $('.confirmEvent').on('click', clickedEvent);
}

function validateInputs()
{
    var name = $("#newWishName").val();
    var price = $("#newWishPrice").val();
    var link = $("#newWishLink").val();
    var comment = $("#newWishNotes").val();
    var quantity = $("#newWishQuantity").val();
    var message = "";
    
    if(name.length < 3) // validate the required inputs
    {
        message += "\nName";
    }
    
    if(price.length < 1)
    {
        message += "\nPrice";
    }
    
    // validate URL if one was set.
    // allow any protocol: ([a-zA-Z]{3,})://([\w-]+\.)+[\w-]+(/[\w- ./?%&=]*)?
    // or allow specific protocols: (http|https|ftp|mailto)://([\w-]+\.)+[\w-]+(/[\w- ./?%&=]*)? 
    var urlregex = new RegExp(/((http|https):\/\/(\w+:{0,1}\w*@)?(\S+)|)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/);
    //urlregex = new RegExp(/^\d+$/);
    //if(link.length <= 0 || !urlregex.test(link))
    if(link.length <= 0 || link.match(/((http|https):\/\/(\w+:{0,1}\w*@)?(\S+)|)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/)==null)
    {
        message += "\nLink";
    }
    
    if(quantity.length > 0 && !isNumeric(quantity))
    {
        message += "\nQuantity"
    }
    
    return message;
}

function submitTheNewWish()
{
    var message = validateInputs();
    
    if(message.length <= 0)
    {
        var itemObj = {name: $("#newWishName").val(), price: $("#newWishPrice").val(), link: $("#newWishLink").val()};
        addToWishlist(itemObj, setupWishlist);
        return;
    }    
    
    alert('Invalid arguments: '+message);
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
            submitTheNewWish();
        }
    });
    
    $('#submitNewWish').click(function(e){
        e.preventDefault();
        submitTheNewWish();               
    })

    $("h3 .ui-icon-close").click(function(e){
        $(wishlist_div).accordion( "option", "disabled", true);
        var itemObj = {name: $(this).next().text()};
        delFromWishlist(itemObj, setupWishlist);
    });
    
    $('.purchaseBtn').on('click', clickedItem);
    
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
    }catch(e)
    {
        giftDate = null;
    }
    
    try
    {
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
    $('h3[id=' + selected_itemId + ']').addClass('purchased');
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
    setupEvents();
});