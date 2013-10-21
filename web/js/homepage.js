/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    
    $.ajaxSetup ({  
        cache: false  
    });
    
    initDialogs();
    initWishlist();
});

function initDialogs(){
    // init item dialog
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
                        onGrantItClickEvent();                     
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
                        alert('to do');
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
            },
            open: function(event, ui) { 
                //$('#wishDetails').hide();
                //styleWishDialogButtons();                
                //$(this).scrollTop(0);
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

function populateEvent(event)
{
    var eventType = event.event_type;
    var div = eventType == 1 ? $('#birthdays') : (eventType == 4 ? $('#anniversaries') : null);
    
    if(div)
    {
        var eventDiv = $("<div/>").attr('id',event.id).html(event.eventdate);
        $(div).append(eventDiv);
    }
}

function setupItemView(data, selfWishlist)
{    
    $('#itemDialog #itemId').val(data.id);
    $('#itemDialog #name').val(data.name);
    $('#itemDialog #price').val(data.price);
    $('#itemDialog #link2').html('<a target="_blank" href="http://'+data.link+'">webpage</a>');
    $('#itemDialog #link').val(data.link);
    $('#itemDialog').dialog('open');  
}

// edit (1) means the item is being editted
// newitem (1) means it's a new item
function setupWishDialogView(data, edit, newitem)
{
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
    }
    
    // TODO: return the privacy attribute in the object so it can be displayed
    
    if(edit == 0) // if not editable, disable the inputs
    {
        $('#editItemDialog input').prop('disabled', true);    
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
        $('#editItemDialog').dialog('option', 'title', 'Save Wish');
    }
    
    $('#editItemDialog').dialog('open'); 
}

function openWishDialog(wishlistItemId, edit, newitem)
{
    // using the item ID, grab the item's info and display in the dialog
    $.getJSON('/app_dev.php/wishlistitem/'+wishlistItemId, function (data) {
        var alertMessage = data.error_message;
        
        if(alertMessage) // an issue occurred
        {
            popupMessage('Sorry!',alertMessage);
        }
        else {
            setupWishDialogView(data, edit, newitem);
        }
    }); 
}

function openDialog(wishlistItemId, selfWishlist)
{
    // using the item ID, grab the item's info and display in the dialog
    $.getJSON('/app_dev.php/wishlistitem/'+wishlistItemId, function (data) {
        var alertMessage = data.error_message;
        
        if(alertMessage) // an issue occurred
        {
            popupMessage('Sorry!',alertMessage);
        }
        else {
            setupItemView(data, selfWishlist);
        }
    }); 
}

function goToUserPage(userId)
{
    var loc = "www.wishlist.com/User";
    window.location = loc;
}

function initWishlist()
{
    console.log('Window: '+$(window).height());
}

function fillPic(item)
{
    var picContainer = $(item).children('span.picContainer');
    var query = $(item).children('label').html();
    
    fillGoogleImage(query, picContainer);
}

function fillGoogleImage(query, picContainer)
{
    var mykey = "AIzaSyBHtgh3ihz8AHCBw0LkEi_Snl96elJCSpA";
    var cx = "015228749791243702187:ctequifxi_s";
    var hndlr = "googleQryHndlr";
    var url = "https://www.googleapis.com/customsearch/v1?key="+mykey+"&cx="+cx+"&q="+query+"&searchType=image&num=1";
    
    $.get(url, function(response) {fillPicContainer(picContainer, response)}, "json");
}

function fillPicContainer(picContainer, response)
{
    picContainer.html( function(index, oldhtml){
        var newhtml = '';
        
        if (response.items.length > 0)
        {
            var item = response.items[0];
            newhtml += "<img class='itemThumb' src='"+item.link+"' />";
        }
        
        return newhtml;
    });
}
