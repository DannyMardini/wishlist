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

function validateInputs(name, price, link, quantity)
{
    var message = "";
    var ignore = 0;
    
    // validate the required inputs
    
    if(name.length < 3) 
    {
        message += "\nName";
        ignore++;
    }
    
    if(price.length < 1 || !IsNumber(price) || (IsNumber(price) && parseInt(price) <= 0 ))
    {
        message += "\nPrice";
        ignore++;
    }
    
    var url_regexp = /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([/\w\.-]*)*\/?$/;
    if(link.length <= 0 || !url_regexp.test(link))
    {
        message += "\nLink";
        ignore++;
    }

    // validate the optional inputs
    
    if(quantity.length > 0 && !IsNumber(quantity) || (IsNumber(quantity) && parseInt(quantity) <= 0) )
    {
        message += "\nQuantity";
        ignore++;
    }
    
    if(ignore > 4)
    {
        return ignore;
    }
    
    return message;
}

function IsNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function submitTheNewWish()
{
    var theName = $("#newWishName").val();
    var thePrice = $("#newWishPrice").val();
    var theLink = $("#newWishLink").val();
    var theQuantity = $("#newWishQuantity").val();
    var theNotes = $("#newWishNotes").val();
    var theIsPrivate = $("#isPrivate").attr('checked');
    
    var message = validateInputs(theName, thePrice, theLink, theQuantity);
    
    if(message = 4)
    {
        return; // ignore if all fiels are empty.
    }
    
    if(message.length <= 0)
    {
        var itemObj = { name: escape(theName), 
                        price: thePrice, 
                        link: theLink, 
                        quantity: theQuantity, 
                        comment: theNotes, 
                        isprivate: theIsPrivate};
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

    $("h3 .ui-icon-close").click(function(){
        if(confirm("Are you sure you want to delete this wish?"))
        {
            $(wishlist_div).accordion( "option", "disabled", true);
            var itemObj = {name: escape($(this).next().text())};
            delFromWishlist(itemObj, setupWishlist);
        }        
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