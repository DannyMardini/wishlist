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
                        continueAddingItemToWishlist();
                        $(this).dialog('close');
                    }
            },
            open: function(event, ui) { 
                $('#wishDetails').hide();
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
