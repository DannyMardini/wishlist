var wishlistElement = '#wishlistContent';
var selected_itemId = -1;
var selected_eventId = -1;
var selected_amazonItem = -1;

var month = [];
month[0] = "January";
month[1] = "February";
month[2] = "March";
month[3] = "April";
month[4] = "May";
month[5] = "June";
month[6] = "July";
month[7] = "August";
month[8] = "September";
month[9] = "October";
month[10] = "November";
month[11] = "December";


function submitTheWish(/* optional wish object param */wish, path, callback, dialog) {        
    // if a pre-defined wish obj was passed in, use that
    if (wish === null) {
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
            
        $(dialog).dialog('close');            
    }
}

function getItemDialogObj(dialog)
{
    return {
         id: $('#itemId', dialog).val(),
         asin: $('#asin', dialog).val(),
         image: $('#image', dialog).val(),
         name: $('#name', dialog).val(), 
         price: $('#price', dialog).val(), 
         link: $('#link', dialog).val(),
         quantity: $('#quantity', dialog).val(),
         comment: $('#notes', dialog).val(),
         isprivate: $('#private', dialog).val()
     };                
}

function onGrantItClickEvent(dialog) {
    // call the method that pops open the dialog for adding the item           
    openAddToShoppingListDialog(getItemDialogObj(dialog));
}

function continueAddingItemToWishlist(dialog)
{
    var wishlistAddItemPath = Routing.generate('WishlistListBundle_wishlistNew');
    var itemObj = getItemDialogObj(dialog);
    submitTheWish(itemObj, wishlistAddItemPath, onCompleteAddToWishlistEvent, dialog); 
}

function highlightEvent(selected)
{
    selected.css('background-color', '#CCCCCC').css('font-weight','bold');
}

function clearEventHighlights()
{
    $('.confirmEvent').css('background-color', '').css('font-weight','normal');
}

function parseEventId(idString)
{
    var split_str = idString.split('_');
    
    if(split_str.length !== 2){
        return -1;  //Return an invalid event id if we couldn't parse
    }
    
    return parseInt(split_str[1]);
}

function selectEvent(selected)
{
    var eventId = parseEventId(selected.attr('id'));
    
    if(eventId < 0){
        return;
    }
    
    selected_eventId = eventId;
    clearEventHighlights();
    highlightEvent(selected);
    // disable the date 
    $('#giftDateInput').val('').prop('disabled',true);
}

function isSelectedEvent(selected)
{
    var eventId = parseEventId(selected.attr('id'));
    
    if( eventId === selected_eventId )
    {
        return true;
    }
    
    return false;
}

// ** Date Validation Functions ****************************
function isValidDate(year, month, day)
{
    var daysInMonth = function (y, m) {return 32-new Date(y, m, 32).getDate(); },
    char_year = year.toString(),
    d = new Date(), 
    curr_year = d.getFullYear();

    if(char_year.length !== 4 || year > (curr_year+200)){
        return false;
    }
    if(month < 0 || month > 11){
        return false;
    }
    if(day < 0 || day > daysInMonth(year, month)){
        return false;
    }
    
    return true;
}

function popupMessage(theTitle, message, callback)
{    
    $('<div id="popupMessageDiv">' + message + '</div>').dialog({
             position: 'top',             
             autoOpen: true,
             close: function () {            
                 $(this).dialog('destroy');
             },
             title: theTitle,
             buttons: {
                 "Ok": function() {
                    if(callback!==undefined)
                    {
                        callback();
                    }
                    $( this ).dialog( "close" );
                 }
             }
         });    
}

function onCompleteAddItemToShoppingList(responseMessage, textStatus, responseObj, itemId){
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

function viewWishlistDialogInit()
{
    if($( "#itemDialog" ).length === 0)
        return;
    
    $( "#itemDialog" ).dialog({
            autoOpen: false,
            position: 'top', 
            resizable: false,
            height:300,
            width:600,
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

function parseDate(/*string*/ str)
{
    var dtCh = "/",
    retDate = new Date(),
    pos1=str.indexOf(dtCh),
    pos2=str.indexOf(dtCh,pos1+1),
    str_arr = null;
    
    if(str === ""){
        //string is not defined        
        throw "Invalid date.";
    }
    
    if (pos1===-1 || pos2===-1)
    {
        throw "Invalid date.";
    }
    else
    {
        str_arr = str.split("/");
    }
    
    var month = parseInt(str_arr[0], 10),
    day = parseInt(str_arr[1], 10),
    year = parseInt(str_arr[2], 10);
    
    //This is quite stupid as monthValue is the only value that begins with an
    //index of zero, subtract one to fix it.
    month--;
    
    if(!isValidDate(year, month, day))
    {
        throw "Invalid date.";
    }
    
    retDate.setFullYear(year, month, day);
    
    return retDate;
}

function unselectEvent()
{
    clearEventHighlights();
    selected_eventId = -1;
    // activate the date field
    $('#giftDateInput').prop('disabled',false);
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

function editWishlistDialogInit()
{
    if($( "#editItemDialog" ).length === 0 ) {
        return;
    }
    
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
                        //$(this).dialog('close');
                    },
                    "Delete": function() {  
                        deleteLoadedItem();
                        $(this).dialog('close');
                    },
                    "Save": function() {
                        continueAddingItemToWishlist(this);
                        //$(this).dialog('close');
                    },                            
                    "Close": function() {
                        $(this).dialog('close');
                    }
            }
    });    
}

function clickedEvent()
{   
    toggleSelectEvent($(this));
}

function confirmDialogClose()
{
    unselectEvent();    
}

function confirmOK()
{
    var purchaseType = null,
    purchaseDue = null,
    giftDate = null;
    
    try
    {
        giftDate = parseDate($('#giftDateInput').attr('value'));
    }catch(e)
    {
        giftDate = null;
    }
    
    try
    {
        if(selected_itemId == null || selected_itemId <= 0)
        {
            throw('An issue occurred! Refresh the browser and try again.');
        }
        
        if((selected_eventId > 0) && (giftDate === null)){
            purchaseType = 'Event';
            purchaseDue = selected_eventId;            
        }
        else if((giftDate !== null) && (selected_eventId < 0)){
            purchaseType = 'Date';
            purchaseDue = giftDate.toDateString();
        }
        
        if(purchaseType === null || purchaseDue === null)
        {
            throw 'Please select either an event or a date.';
        }
        
        item = {id: selected_itemId, purchaseData: purchaseDue, type: purchaseType};
        ajaxPost(item, Routing.generate('WishlistListBundle_purchaseItem'), onCompleteAddItemToShoppingList, item.id);
    }catch(e)
    {
        popupMessage('Uh Oh!', e);
    }
}

function setupConfirmDialog()
{
    if($('#confirmDialog').length === 0) {
        return;
    }
    
    $('#confirmDialog').dialog(
        {
            autoOpen: false,
            position: 'top',
            modal: true,
            resizable: false,
            height:500,
            width:400,
            buttons: {
                'Ok': function(){
                    confirmOK();                    
                },
                'Cancel': function(){
                    $(this).dialog('close');
                }
            },
            close: confirmDialogClose
        }
    );
}

function setupEvents()
{
    $('.confirmEvent').on('click', clickedEvent);
}

function initWishlistDialogs()
{
    amazonSearchDialogInit();
    editWishlistDialogInit();
    viewWishlistDialogInit();
}

function get_nth_suffix(date) {
  switch (date) {
    case 1:
    case 21:
    case 31:
       return 'st';
    case 2:
    case 22:
       return 'nd';
    case 3:
    case 23:
       return 'rd';
    default:
       return 'th';
  }
}

$(document).ready(function(){
    initWishlistDialogs();
    setupEvents();
    setupConfirmDialog();
    
    if($('#giftDateInput').length > 0)
    {
        $('#giftDateInput').datepicker();
    }
});

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
    
    var url_regexp = /((([A-Za-z]{3,9}:(?:\/\/)?)(?:[\-;:&=\+\$,\w]+@)?[A-Za-z0-9\.\-]+|(?:www\.|[\-;:&=\+\$,\w]+@)[A-Za-z0-9\.\-]+)((?:\/[\+~%\/\.\w\-_]*)?\??(?:[\-\+=&;%@\.\w_]*)#?(?:[\.\!\/\\\w]*))?)/;
    if(link == null || link.length <= 0 || !url_regexp.test(link))
    {
        message += "<br />Link";
    }
    
    return (message.length > 0)
                        ? "The following Wish properties were not set properly:<br /> " + message 
                        : message;
}

//todo: Need to fix this, should be using responseText.
function onCompleteAddToWishlistEvent(responseText, textStatus, jqXHR)
{    
    switch(textStatus.toLowerCase())
    {
        case "notmodified":
            popupMessage('Oh!','This item is already on your list! To edit the item, access it from your wishlist.');    
            break;
        case "success":
            var jqWishlistElement = $(wishlistElement);
            if(jqWishlistElement.length > 0) {
                setupWishlist(); //Only update wishlist if page includes it.
            }
            popupMessage('Yay!','The item has been added to your list!');
            break;
        default:
            popupMessage('Sorry!', 'The item could not be added.');
            location.reload();
            break;       
    }
}

function onWantItClickEvent() {
    openWishDialog($('#itemDialog #itemId').val(), {edit:"1",newItem:"1"}, setupWishDialogView);
    $("#itemDialog").dialog('close');  
}

function getUserEvents(itemId) {
    var url = Routing.generate('WishlistListBundle_eventlist');
    ajaxPost({itemId: itemId}, url, function(response, textStatus) {
        if(response){
            $('#confirmEventContainer').removeClass('message');
            $('#confirmEventContainer').html(response);
            setupEvents();
        }
        else {
            $('#confirmEventContainer').html('User has not created any events.');
            $('#confirmEventContainer').addClass('message');
        }
        $('#confirmDialog').dialog('open');
    });
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
    getUserEvents(item.id);
    
    if(selected_itemId <= -1 || selected_itemId == "")
    {
        selected_itemId = item.id;
    }    
}

function openAddToShoppingListDialog(item)
{
    populateDialogItemInfo(item);
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

function viewWishlistDialogInit()
{
    if($( "#itemDialog" ).length == 0){
        return;
    }
    
    $( "#itemDialog" ).dialog({
            autoOpen: false,
            position: 'top', 
            resizable: false,
            height:300,
            width:600,
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

function fillResults(data, textStatus, jqXHR)
{
    $('#resultsArea').html(data);
    $('#resultsArea td.searchResultItemName').click(function() {
        if($(this).hasClass('selected')) {      //If the item is already selected, de-select it. 
            $(this).removeClass('selected');
            selected_amazonItem = -1;
        }
        else {  //Else if it is not already selected, select it.
            $('#resultsArea td.searchResultItemName').removeClass('selected');
            $(this).addClass('selected');
            selected_amazonItem = $(this).parent().attr('id');
        }
    });
}

function addAmazonItemToWishlist()
{
    if(selected_amazonItem != -1) {
        //Get tr with id selected, use jQuery( "[attribute*='value']" )
        var rowCells = $("tr[id*='" + selected_amazonItem + "']").children('td');
        
        //extract data from rows
        var data = {}
        data.asin  = selected_amazonItem;
        data.image = $(rowCells[0]).find('img').attr('src');
        data.link  = $(rowCells[0]).children('a').attr('href');
        data.name  = $(rowCells[1]).html();
        data.price = $(rowCells[2]).children('span.searchResultItemPrice').html();
        
        setupWishDialogView(data, {edit: 1, newItem: 1});
    }
    else {
        popupMessage('Oops', 'You forgot to select an item!');
    }
}

function amazonSearchDialogInit()
{
    var amazonDialog = $( "#amazonSearchDialog" );
    if(amazonDialog.length <= 0)
    {
        return; // the dialog does not exist
    }
    
    $('#name',amazonDialog).keyup(function(e) {
        if(e.keyCode === 13) {
            ajaxPost({keywords: $(this).val()}, Routing.generate("WishlistListBundle_itemSearch"), fillResults);
        }
    });
    
    amazonDialog.dialog({
            autoOpen: false,
            position: 'top', 
            resizable: false,
            width:500,
            modal: true,
            title: 'Amazon Search',
            close: function(){
                var popup = $('#popupMessageDiv');
                if(popup.length > 0)
                {
                    popup.dialog('close');
                }
            },
            buttons: {            
                    "Select": function() {
                        addAmazonItemToWishlist();
                    },                            
                    "Close": function() {
                        $(this).dialog('close');
                    }
            }
    });
    
    $('#otherItem',amazonDialog).click(function(){
        amazonDialog.dialog('close');
        setupWishDialogView(null,{edit:"1", newItem:"1"});
    });
}

function editWishlistDialogInit()
{
    if($( "#editItemDialog" ).length == 0 ){
        return;
    }
    
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
                    },
                    "Delete": function() {  
                        deleteLoadedItem();
                        $(this).dialog('close');
                    },
                    "Save": function() {
                        continueAddingItemToWishlist(this);
                        
                        //close amazon search dialog if it is open.
                        $( "#amazonSearchDialog" ).dialog('close');
                    },                            
                    "Close": function() {
                        $(this).dialog('close');
                    }
            }
    });    
}

/* POST: ajax call
 * TO DO: have other ajax call this generic method instead
 * */
function ajaxPost(data, url, callback, callBackParams)
{
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function(data, textStatus, jqXHR) { 
            if(callback)
            {
                callback.call(null, data, textStatus, jqXHR, callBackParams);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            if(callback)
            {
                callback.call(null, jqXHR.responseText, textStatus, jqXHR, callBackParams);
            }
        }
    });    
}

function ajaxPageLoad(element, path, itemObj, callback)
{
    var jqElement = $(element);
    if(jqElement.length > 0) {
        jqElement.load(path, itemObj, callback);
    }
    else {
        $.get(path, itemObj, callback);
    }
}

function delFromWishlist(itemObj, callback)
{
    var wishlistItemURL = Routing.generate('WishlistListBundle_wishlistDelete');
    $("#wishlistContent").load(wishlistItemURL, itemObj, callback);
}

// paramsObj {tags: "cat", tagmode: "any", format: "json"}
function ajaxCall(url, paramsObj, onSuccessMethod)
{
    $.post(url, paramsObj, function(data) {
        if(onSuccessMethod) {
            onSuccessMethod(data);
        }
    });
}

//Browser Support Code
function ajaxFunction(queryString){
    var ajaxRequest;  // The variable that makes Ajax possible!

    try
    {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } 
    catch (e)
    {        
        try
        {
            // Internet Explorer Browsers
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } 
        catch (e) 
        {
            try
            {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } 
            catch (e)
            {
                // Something went wrong
                alert("Unable to complete the request.");
                return false;
            }
        }
    }
    
    // Create a function that will receive data sent from the server
    ajaxRequest.onreadystatechange = function(){
            if(ajaxRequest.readyState == 4){
            }
    }
    
    ajaxRequest.open("GET", "ajax-example.php" + queryString, true);
    ajaxRequest.send(null); 
}

// ** Date Validation Functions ****************************
function isValidDate(year, month, day)
{
    var daysInMonth = function (y, m) {return 32-new Date(y, m, 32).getDate();};
    var char_year = year.toString();    
    var d = new Date();var curr_year = d.getFullYear();

    if(char_year.length != 4 || year > (curr_year+200))
        return false;
    
    if(month < 0 || month > 11)
        return false;
    
    if(day < 0 || day > daysInMonth(year, month))
        return false;
    
    return true;
}

function parseDate(/*string*/ str)
{
    var dtCh = "/";
    var retDate = new Date();
    var pos1=str.indexOf(dtCh);
    var pos2=str.indexOf(dtCh,pos1+1);
    var str_arr = null;
    
    if(str == ""){
        //string is not defined        
        throw "Invalid date.";
    }
    
    if (pos1==-1 || pos2==-1)
    {
        throw "Invalid date.";
    }
    else
    {
        str_arr = str.split("/");
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
    
    return retDate;
}

// ** Date Validation Functions ****************************

function confirm (confirmMessage) {
    var defer = $.Deferred(); 
    $('<div>' + confirmMessage + '</div>').dialog({
            position: 'top',
            height: 300,
            width: 300,
            modal: true,
            autoOpen: true,
            close: function () { 
                $(this).dialog('destroy');
            },
            title: 'Continue?',
            buttons: {
                "Yes": function() {
                    defer.resolve(1); //on Yes click, end deferred state successfully with 1 value
                    $( this ).dialog( "close" );
                },
                "No": function() {
                    defer.resolve(0); //on No click end deferred successfully with 0 value
                    $( this ).dialog( "close" );
                }
            }
        });
    return defer.promise(); //important to return the deferred promise
}

function whatIsIt(object) {
    var stringConstructor = "test".constructor;
    var arrayConstructor = [].constructor;
    var objectConstructor = {}.constructor;
        
    if (object === null) {
        return "null";
    }
    else if (object === undefined) {
        return "undefined";
    }
    else if (object.constructor === stringConstructor) {
        return "String";
    }
    else if (object.constructor === arrayConstructor) {
        return "Array";
    }
    else if (object.constructor === objectConstructor) {
        return "Object";
    }
    else {
        return "don't know";
    }
}

function IsNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
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

// edit (1) means the item is being editted
// newitem (1) means it's a new item
function setupWishDialogView(data, options)
{
    var edit = options.edit;
    var newitem = options.newItem;
    var buttonPane = $('.ui-dialog-buttonpane');
    var editItemDialog = $('#editItemDialog');
    var updateButton = buttonPane.find('button:contains("Update")');
    var deleteButton = buttonPane.find('button:contains("Delete")');
    var grantButton = buttonPane.find('button:contains("Grant")');
    var saveButton = buttonPane.find('button:contains("Save")');
    
    updateButton.show(); deleteButton.show(); grantButton.show(); saveButton.show();
    
    var name = $('#name',editItemDialog);
    var asin = $('#asin',editItemDialog);
    var image = $('#image',editItemDialog);
    var price = $('#price',editItemDialog);
    var link = $('#link',editItemDialog);
    var id = $('#itemId',editItemDialog);
    var quantity = $('#quantity',editItemDialog);
    var notes = $('#notes',editItemDialog);
    
    // clear everything out first
    id.val(''); image.val(''); quantity.val(''); notes.val('');
    name.prop('disabled', false).val(''); 
    price.prop('disabled', false).val(''); 
    link.prop('disabled', false).val('');
    
    if(data){
        editItemDialog.dialog('option', 'title', 'Edit Wish');
        id.val(data.id); // is this the item or wish ID?
        if('asin' in data) {
            asin.val(data.asin);
        }
        image.val(data.image);
        name.val(data.name);
        price.val(data.price);
        link.val(data.link);
        quantity.val(data.quantity);
        var comment = (newitem == 1) ? "" : data.comment;
        notes.val(comment);
        
        name.prop('disabled', true); 
        price.prop('disabled', true); 
        link.prop('disabled', true);        
    }
        
    if(edit == 0) // if not editable, disable the inputs
    {
        $('#editItemDialog input').prop('disabled', true);
        
        // hide the update button and display a save button
        updateButton.hide(); deleteButton.hide(); saveButton.hide();
        $(grantButton).show();
        editItemDialog.dialog('option', 'title', 'View Wish');
    }
    else 
    {
        saveButton.hide();
    }
    
    if(newitem == 1) // if this is a new item, show the save button
    {
        // hide the update button and display a save button
        updateButton.hide(); deleteButton.hide(); grantButton.hide();
        $(saveButton).show();        
        name.prop('disabled', false); price.prop('disabled', false); link.prop('disabled', false);
        editItemDialog.dialog('option', 'title', 'Save Wish');
    }
    
    editItemDialog.dialog('option', 'height', '500').dialog('open');    
}

function setupItemView(data)
{   
    var itemDialog = $('#itemDialog');
    var link = data.link;
    
    $('#linkButton',itemDialog).button({
        icons: { primary: "ui-icon-link" }
    }).unbind('click')
    .click(function(){
        var protocol = "http\://"
        if(link.indexOf(protocol) == -1) {
            link = protocol+link;
        }
        window.open(link,'_blank');
    });
    
    $('#itemId', itemDialog).val(data.id);
    $('#image', itemDialog).val(data.image);
    $('#name', itemDialog).html(data.name);
    $('#price', itemDialog).html(data.price);
    $('#link', itemDialog).html(data.link);
    $('#itemDetails2', itemDialog).html(data.comment);
    $('#quantity2', itemDialog).html(data.quantity);

    itemDialog.dialog('option', 'height', '500').dialog('open');    
}

function getIds(elements)
{
    var expiredPurchases = [];
    
    elements.each(function(index, element) {
        expiredPurchases.push(element.id);
    });

    return expiredPurchases;
}

function removeSpecialChars(val)
{    
    var regex = /["\<\>\*\@\.\#\$\%\^\(\)\,\/\!\?\"\'\:\;\}\{\|\\\+\=\_\-\~\[\]\`\&]/g;
    if(val.match(regex)){
        val = val.replace(regex, "");
    }
    
    return val;
}
