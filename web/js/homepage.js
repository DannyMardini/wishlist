/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// buttons used for the dialog
var addToWishlistButton =  {
            priority: 'primary',  
            id: 'addToWishlistButton',
            title: 'Add to my wishlist',
            click: function() {
            
            }
        };
        
function onWantItClickEvent() {
    // ask them to fill out the additional details first
    var response = alert('Would you like to fill out the quantity, notes, and privacy first?');
    
    if(response == 'Yes'){
        $('#wishDetails').show();
    }
    
    // Hide the Grant Wish button and Change the text of the Want It button to Continue
    var buttonPane = $('.ui-dialog-buttonpane');
    buttonPane.find('button').hide();
    buttonPane.find('button:contains("Add Wish")').show();
    
    return;
    
   

    var itemObj = {
        name: $('#itemDialog #name').html(), 
        price: $('#itemDialog #price').html(), 
        link: $('#itemDialog #link').html(),
        quantity: $('#itemDialog #quantity').html(),
        comment: $('#itemDialog #notes').html(),
        isprivate: $('#itemDialog #private').html()
    };

    submitTheNewWish(itemObj); // defined in wishlist.js
    
    
    // Hide the add wish button now that we are done adding it
    buttonPane.find('button').show();
    buttonPane.find('button:contains("Add Wish")').hide();
    
    // Close the dialog
    $("#itemDialog").dialog('close');
                

//                    onCompleteAddToWishlistEvent);    
}

$(document).ready(function(){
    
    $.ajaxSetup ({  
        cache: false  
    });
    
    // init item dialog
    $( "#itemDialog" ).dialog({
            autoOpen: false,
            position: 'center', 
            resizable: false,
            height:300,
            width:500,
            modal: true,
            buttons: {
                    "Want This": function() {
                        onWantItClickEvent();
                    },
                    "Grant Wish": function() {
                      /* Do stuff*/  
                      alert('TO DO');
                      $(this).dialog('close');
                    },
                    "Add Wish": function() {
                        alert('To Do');
                        $(this).dialog('close');
                    }
            },
            open: function(event, ui) {
                styleWishDialogButtons();
                $(this).scrollTop(0);
            }
    });   

    
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
        // If we want to remove the text, just remove the text-only classes. Below is an example:
        //    $('#addToWishlistButton').removeClass('ui-button-text-only');
        //    $('#addToWishlistButton :first-child').removeClass('ui-button-text');
        //    $('#addToWishlistButton :first-child').addClass('ui-icon ui-icon-plus');
        //    $('#addToWishlistButton').addClass('itemDialogButton');        
    }
}


    
    initWishlist();
});

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

function onCompleteAddToWishlistEvent(e)
{
    if(e.indexOf('Error') < 0){
        setupWishlist();

        if(e.match('newWishBox') != null)
            alert('Item has been added to your list!');
        else
            alert('This item is already on your list.');        
        }
    else {
        alert("Sorry! The item could not be added.");
    }

}

function setupItemView(data)
{
    $('#itemDialog #name').html(data.name);
    $('#itemDialog #price').html(data.price);
    $('#itemDialog #link').html('<a target="_blank" href="http://'+data.link+'">webpage</a>');
    $('#itemDialog').dialog('open');         
}

function openDialog(itemId)
{
    // using the item ID, grab the item's info and display in the dialog
    $.getJSON('/app_dev.php/wishlistitem/'+itemId, function (data) {
      setupItemView(data);     
    }); 
}

function goToUserPage(userId)
{
    var loc = "www.wishlist.com/User";
    window.location = loc;
}

function initWishlist()
{
    var navigationlist = $('#navigationlist');
    var wishlistContent = $('#wishlistContent');
    var wishlistBox = $('#wishlistBox');
    
    console.log('Window: '+$(window).height());
    wishlistContent.height(wishlistBox.height()-navigationlist.height());
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
//    var query = "Metal+Gear+Solid";
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
