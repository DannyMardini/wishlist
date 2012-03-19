/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// buttons used for the dialog
var addToWishlistButton =  {
            priority: 'primary',           
            id: 'addToWishlistButton',
            label: 'add to my wishlist',
            click: function() {
                   addToWishlist({newWishName: $('#itemDialog #name').html(), newWishPrice: $('#itemDialog #price').html(), newWishLink: $('#itemDialog #link').html()}, onCompleteAddToWishlistEvent);
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
    
    
    displayUpcomingEvents();

});


function displayUpcomingEvents()
{
    // using the item ID, grab the item's info and display in the dialog
    $.getJSON('/homepage/'+$('#id').val()+'/', function (data) {
       $(data.events).each(function () {
            populateEvent(this);            
        });
    });     
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
    $.getJSON('/app_dev.php/wishlistitem/'+itemId, function (data) {
      setupItemView(data);     
    }); 
}


function goToUserPage(userId)
{
    var loc = "www.wishlist.com/user/"+id;
    window.location = loc;
}  
 
 
       
        


