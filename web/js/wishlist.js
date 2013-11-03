/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var wishlist_div = "#div_wishlist_div";
var selected_itemId = -1;
var selected_eventId = -1;
var wishlistAddItemPath = '/app_dev.php/wishlistnew';
var wishlistUpdateItemPath = '/app_dev.php/wishlistupdate';
var wishlistElement = '#wishlist';

$(document).ready(function(){
    initWishlistDialogs();
    setupWishlist();
    setupEvents();
});

function initWishlistDialogs()
{
    editWishlistDialogInit();
    viewWishlistDialogInit();
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
        setupWishDialogView(null,{edit:"1", newItem:"1"});
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
    
    editWishlistDialogInit();
}

function confirmDialogClose()
{
    unselectEvent();
    $('#confirmBtn').unbind('click');
}

function confirmDialogOpen()
{
    //Give the confirm button focus.
    $('#confirmBtn').focus();
    
    //Set up purchase button
    $('#confirmBtn').click(confirmOK);
}

function unselectEvent()
{
    clearEventHighlights();
    selected_eventId = -1;
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

function setupEvents()
{
    $('.confirmEvent').on('click', clickedEvent);
}

function editWishlistDialogInit()
{
   $( "#editItemDialog" ).dialog({
            autoOpen: false,
            position: 'top', 
            resizable: false,
            height:300,
            width:500,
            modal: true,
            buttons: {
                    "Grant": function() {
                        onGrantItClickEvent(this); 
                    },
                    "Update": function() {
                        onUpdateWishItemClick(this);
                        $(this).dialog('close');
                    },
                    "Delete": function() {  
                        deleteLoadedItem();
                        $(this).dialog('close');
                    },
                    "Save": function() {
                        continueAddingItemToWishlist(this);
                        $(this).dialog('close');
                    },                            
                    "Close": function() {
                        $(this).dialog('close');
                    }
            }
    });    
}

function viewWishlistDialogInit()
{
    $( "#itemDialog" ).dialog({
            autoOpen: false,
            position: 'top', 
            resizable: false,
            height:300,
            width:500,
            modal: true,
            buttons: {
                    "Want This": function() {
                        onWantItClickEvent();
                    },
                    "Grant Wish": function() {                                            
                        onGrantItClickEvent(this);                     
                    },
                    "Add Wish": function() {
                        continueAddingItemToWishlist(this);
                        $(this).dialog('close');
                    }
            },
            open: function(event, ui) { 
                styleWishDialogButtons();                
                $(this).scrollTop(0);
            }
    });    
}

function styleWishDialogButtons()
{
    var buttons = $('.ui-dialog-buttonpane'),
        wantIt = buttons.find('button:contains("Want This")'),
        grantIt = buttons.find('button:contains("Grant Wish")'),
        addWish = buttons.find('button:contains("Add Wish")'),
        iconNotDefined = !wantIt.find(":first-child").hasClass('ui-icon-plus');

    addWish.hide();

    if(iconNotDefined)
    {
        wantIt.prepend('<span style="float:left;" class="ui-icon ui-icon-plus"></span>');
        grantIt.prepend('<span style="float:left;" class="ui-icon ui-icon-cart"></span>');
    }
    else {
        wantIt.show();
        grantIt.show();        
    }
}

function openWishDialog(wishlistItemId, options, callback)
{
    var wishlistItemURL = Routing.generate('WishlistListBundle_wishlistItem',{itemId: wishlistItemId});
    
    // using the item ID, grab the item's info and display in the dialog
    $.getJSON(wishlistItemURL, function (data) {
        var alertMessage = data.error_message;
        
        if(alertMessage) // an issue occurred
        {
            popupMessage('Sorry!',alertMessage);
        }
        else {
            callback(data, options);
        }
    }); 
}

function setupItemView(data)
{    
    $('#itemDialog #itemId').val(data.id);
    $('#itemDialog #name').val(data.name);
    $('#itemDialog #price').val(data.price);
    $('#itemDialog #link2').html('<a target="_blank" href="http://'+data.link+'">webpage</a>');
    $('#itemDialog #link').val(data.link);
    $('#itemDialog').dialog('open');  
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

function submitTheWish(/* optional wish object param */wish, path, callback)
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
            path,                           // Path to the backend controller
            wish,                           // Wish object
            callback                        // Handles events after the controller is finished
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
    getUserEvents(item.id);
    
    if(selected_itemId <= -1 || selected_itemId == "")
    {
        selected_itemId = item.id;
    }    
}

function getUserEvents(itemId) {
    var url = Routing.generate('WishlistListBundle_eventlist');
    ajaxPost({itemId: itemId}, url, function(response, textStatus) {
        $('#confirmEventContainer').html(textStatus.responseText);
        setupEvents();
        $('#confirmDialog').dialog('open');
    });
}

function onGrantItClickEvent(dialog) {
    // Ask them to confirm first
    confirm('Are you sure you want to add this item to your shopping list?')
    .then(function(answer){
        if(answer == 1)
        {
            // call the method that pops open the dialog for adding the item           
            openAddToShoppingListDialog(getItemDialogObj(dialog));
        }
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

function openAddToShoppingListDialog(item)
{
    populateDialogItemInfo(item);
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
    openWishDialog($('#itemDialog #itemId').val(), {edit:"1",newItem:"1"}, setupWishDialogView);
    $("#itemDialog").dialog('close');  
}

function continueAddingItemToWishlist(dialog)
{
    var buttonPane = $('.ui-dialog-buttonpane');
    var itemObj = getItemDialogObj(dialog);

    submitTheWish(itemObj, wishlistAddItemPath, onCompleteAddToWishlistEvent);

    // Hide the add wish button now that we are done adding the item
    buttonPane.find('button').show();
    buttonPane.find('button:contains("Add Wish")').hide();   
}

// edit (1) means the item is being editted
// newitem (1) means it's a new item
function setupWishDialogView(data, options)
{
    var edit = options.edit;
    var newitem = options.newItem;
    var buttonPane = $('.ui-dialog-buttonpane');
    
    buttonPane.find('button:contains("Update")').show();
    buttonPane.find('button:contains("Delete")').show();
    buttonPane.find('button:contains("Grant")').show();
    buttonPane.find('button:contains("Save")').show();
    
    // clear everything out first
    $('#editItemDialog #itemId').val(''); // is this the item or wish ID? 
    $('#editItemDialog #name').val('');
    $('#editItemDialog #price').val('');
    $('#editItemDialog #link').val('');
    $('#editItemDialog #quantity').val('');
    $('#editItemDialog #notes').val('');    
    
    if(data){
        $('#editItemDialog').dialog('option', 'title', 'Edit Wish');
        $('#editItemDialog #itemId').val(data.id); // is this the item or wish ID? 
        $('#editItemDialog #name').val(data.name);
        $('#editItemDialog #price').val(data.price);
        $('#editItemDialog #link').val(data.link);
        $('#editItemDialog #quantity').val(data.quantity);
        var comment = (newitem == 1) ? "" : data.comment;
        $('#editItemDialog #notes').val(comment);
        $('#editItemDialog #isPrivate').prop('checked', !data.public);
    }
    
    if(edit == 0) // if not editable, disable the inputs
    {
        $('#editItemDialog input').prop('disabled', true);
        
        // hide the update button and display a save button
        buttonPane.find('button:contains("Update")').hide();
        buttonPane.find('button:contains("Delete")').hide();
        buttonPane.find('button:contains("Grant")').show();
        buttonPane.find('button:contains("Save")').hide();
        $('#editItemDialog').dialog('option', 'title', 'View Wish');
    }
    else 
    {
        buttonPane.find('button:contains("Save")').hide();
    }
    
    if(newitem == 1) // if this is a new item, show the save button
    {
        // hide the update button and display a save button
        buttonPane.find('button:contains("Update")').hide();
        buttonPane.find('button:contains("Delete")').hide();
        buttonPane.find('button:contains("Grant")').hide();
        buttonPane.find('button:contains("Save")').show();
        
        $('#name').prop('disabled', false);
        $('#price').prop('disabled', false);
        $('#link').prop('disabled', false);
        
        $('#editItemDialog').dialog('option', 'title', 'Save Wish');
    }
    
    $('#editItemDialog').dialog('open'); 
}
