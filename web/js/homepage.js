/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// buttons used for the dialog
// TODO: What does this do?? Do we even use this?
var addToWishlistButton =  {
            priority: 'primary',           
            id: 'addToWishlistButton',
            label: 'add to my wishlist',
            click: function() {
                   addToWishlist({newWishName: $('#itemDialog #name').html(), 
                       newWishPrice: $('#itemDialog #price').html(), 
                       newWishLink: $('#itemDialog #link').html()}, 
                       onCompleteAddToWishlistEvent);
            }
        };

var itemDialogButtons = [ addToWishlistButton ];
    


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
            buttons: itemDialogButtons,
            open: function(event, ui) {
                $(this).scrollTop(0);
            }
    });   
    
    $('#addToWishlistButton').removeClass('ui-button-text-only');
    $('#addToWishlistButton :first-child').removeClass('ui-button-text');
    $('#addToWishlistButton :first-child').addClass('ui-icon ui-icon-cart');
    $('#addToWishlistButton').addClass('itemDialogButton');
    
//    displayUpcomingEvents();
    initGiftBox();
});


//function displayUpcomingEvents()
//{
//    // using the item ID, grab the item's info and display in the dialog
//    $.getJSON('/homepage/'+$('#id').val()+'/', function (data) {
//       $(data.events).each(function () {
//            populateEvent(this);            
//        });
//    });     
//}

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
    setupWishlist();

    if(e.match('newWishBox') != null)
        alert('Item has been added to your list!');
    else
        alert('This item is already on your list.');
}

function setupItemView(data)
{
    $('#itemDialog #name').html(data.name);
    $('#itemDialog #price').html(data.price);
    $('#itemDialog #comment').html(data.comment);
    $('#itemDialog #quantity').html(data.quantity);
    $('#itemDialog #link').html('<a target="_blank" href="http://'+data.link+'">'+data.link+'</a>');
    
    $('#itemDialog').dialog('open');         
}

function openDialog(itemId)
{
    // using the item ID, grab the item's info and display in the dialog
    $.getJSON('/app_dev.php/item/'+itemId, function (data) {
      setupItemView(data);     
    }); 
}

function goToUserPage(userId)
{
    var loc = "www.wishlist.com/User";
    window.location = loc;
}

function initGiftBox()
{
    var giftNav = $('#giftNav');
    var giftWindow = $('#giftContent');
    var giftBox = $('#giftBox');
    
    console.log('Window: '+$(window).height());
    giftWindow.height(giftBox.height()-giftNav.height());
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
