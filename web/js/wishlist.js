/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var wishlist_div = "#div_wishlist_div";
var selected_itemId = -1;
var selected_eventId = -1;
var wishlistAddItemPath = '/app_dev.php/wishlistnew';
var wishlistElement = '#wishlist';

function setupEvents()
{
    $('.confirmEvent').on('click', clickedEvent);
}

function validateWish(wish)
{
    var message = "";
    
    if(!wish)
    {
        return "The wish object is empty.";
    }
    
    var name = wish.name, 
        price = wish.price,
        link = wish.link;
    
    
    // validate the required inputs
    if(name.length < 3) 
    {
        message += "<br />Name";
    }
    
    if(price.length < 1 || !IsNumber(price) || (IsNumber(price) && parseInt(price) <= 0 ))
    {
        message += "<br />Price";
    }
    
    var url_regexp = /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([/\w\.-]*)*\/?$/;
    if(link== null || link.length <= 0 || !url_regexp.test(link))
    {
        message += "<br />Link";
    }
    
    return (message.length > 0)
                        ? "The following Wish properties were not set properly:<br /> " + message 
                        : message;
}

function IsNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function submitTheNewWish(/* optional wish object param */wish)
{        
    // if a pre-defined wish obj was passed in, use that
    if(wish == null) {
        var theName = $("#newWishName").val();
        var thePrice = $("#newWishPrice").val();
        var theLink = $("#newWishLink").val();
        var theQuantity = $("#newWishQuantity").val();
        var theNotes = $("#newWishNotes").val();
        var theIsPrivate = $("#isPrivate").attr('checked');
        
        wish = { name: escape(theName), 
                 price: thePrice, 
                 link: theLink, 
                 quantity: theQuantity, 
                 comment: theNotes, 
                 isprivate: theIsPrivate
             };
    }
    
    var invalidWishMessage = validateWish(wish); 
    
    if(invalidWishMessage.length > 0)
    {
        popupMessage('Uh Oh!', invalidWishMessage);
    }
    else
    {
        ajaxPageLoad(
            wishlistElement,                // jQuery wishlist element
            wishlistAddItemPath,            // Path to the backend controller for adding a wish
            wish,                           // Wish object
            onCompleteAddToWishlistEvent    // Handles events after adding a wish
        );
    }
}

function onCompleteAddToWishlistEvent(responseText, textStatus)
{    
    switch(textStatus.toLowerCase())
    {
        case "notmodified":
            popupMessage('Oh!','This item is already on your list! To edit the item, access it from your wishlist.');    
            break;
        case "success":
            setupWishlist();
            popupMessage('Yay!','The item has been added to your list!');
            break;
        default:
            popupMessage('Sorry!', 'The item could not be added.');
            location.reload();
            break;       
    }
}

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
        setupWishDialogView(null,1,1);
    });
    
    $('.purchaseBtn').on('click', clickedItem);
    
    $('#confirmDialog').dialog(
        {
            autoOpen: false,
            position: 'top',
            modal: true,
            open: confirmDialogOpen,
            close: confirmDialogClose
        }
    );
        
    $('#giftDateInput').datepicker();
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
    var purchaseType = null;
    var purchaseDue = null;
    
    try
    {
        var giftDate = parseDate($('#giftDateInput').attr('value'));
    }catch(e)
    {
        giftDate = null;
    }
    
    try
    {
        if(selected_itemId == null || selected_itemId <= 0)
        {
            throw('Item is invalid.')
        }
        
        if((selected_eventId > 0) && (giftDate == null)){
            purchaseType = 'Event';
            purchaseDue = selected_eventId;            
        }
        else if((giftDate != null) && (selected_eventId < 0)){
            purchaseType = 'Date';
            purchaseDue = giftDate.toDateString();
        }
        
        if(purchaseType == null || purchaseDue == null)
        {
            throw 'Please select either an event or a date.';
        }
        
        item = {id: selected_itemId, purchaseData: purchaseDue, type: purchaseType};
        ajaxPost(item, '/app_dev.php/purchaseItem', onCompleteAddItemToShoppingList, item.id);
    }catch(e)
    {
        alert(e);
        return;
    }
}

function onCompleteAddItemToShoppingList(responseMessage, responseObj, itemId){
    $('h3[id=' + itemId + ']').addClass('purchased');
    $('#confirmDialog').dialog('close');        

    // if an empty string was returned it means that no errors occurred.
    if(responseObj.responseText.length <= 0){
        popupMessage('Done!', 'The item was successfully added to your shopping list.', 
            function(){
                location.reload();
            });
    }
    else { // display the error if any occurred        
        popupMessage('Sorry!','<p>'+responseObj.responseText+'</p>');
    }
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
    
    var type = whatIsIt(itemInfo);
    
    if(type == "null" || type == "undefined")
    {
        return;
    }
    
    var item = (type == "String") ? JSON.parse(itemInfo) : itemInfo;        
    
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

function onGrantItClickEvent(dialog) {
    // Ask them to confirm first
    confirm('Are you sure you want to add this item to your shopping list?')
    .then(function(answer){
        if(answer == 1)
        {
            // call the method that pops open the dialog for adding the item           
            openAddToShoppingListDialog(getItemDialogObj(dialog));
        }
    })
}

function openAddToShoppingListDialog(item)
{
    populateDialogItemInfo(item);
    if(selected_itemId <= -1)
    {
        selected_itemId = item.id;
    }
    $('#confirmDialog').dialog('open');    
}

function getItemDialogObj(dialog)
{
    return {
         id: $('#itemId', dialog).val(),
         name: $('#name', dialog).val(), 
         price: $('#price', dialog).val(), 
         link: $('#link', dialog).val(),
         quantity: $('#quantity', dialog).val(),
         comment: $('#notes', dialog).val(),
         isprivate: $('#private', dialog).val()
     };                
}

function onWantItClickEvent() {
    openWishDialog($('#itemDialog #itemId').val(), 1, 1);
    $("#itemDialog").dialog('close');  
}

function continueAddingItemToWishlist(dialog)
{
    var buttonPane = $('.ui-dialog-buttonpane');
    var itemObj = getItemDialogObj(dialog);

    submitTheNewWish(itemObj); // defined in wishlist.js 

    // Hide the add wish button now that we are done adding it
    buttonPane.find('button').show();
    buttonPane.find('button:contains("Add Wish")').hide();   
}