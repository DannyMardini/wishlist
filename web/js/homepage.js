/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// buttons used for the dialog
var addToWishlist =  {                        
            priority: 'primary',           
            id: 'addToWishlistButton',
            label: 'add to my wishlist',
            click: function() {
                   addToWishlist({newWishName: $('#itemDialog #name').html(), newWishPrice: $('#itemDialog #price').html(), newWishLink: $('#itemDialog #link').html()}, setupWishlist);
            }
        };

var itemDialogButtons = [ addToWishlist ];
    


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

});


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
    $.getJSON('/wishlistitem/'+itemId+'/', function (data) {
      setupItemView(data);     
    }); 
    
    
    
}


function goToUserPage(userId)
{
    var loc = "www.wishlist.com/user/"+id;
    window.location = loc;
}  
 
 
       
        


