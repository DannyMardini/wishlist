/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// buttons used for the dialog
var okLabel = "Ok";
var addToWishlist = "I want!";
var buttons = {};

buttons[okLabel] = function(){$(this).dialog("close");};
buttons[addToWishlist] = function(){alert('to do');};


$(function() {    
    
});

function openDialog(itemId)
{    
    // using the item ID, grab the item's info and display in the dialog
    
    $( "#testDialog" ).dialog({
            position: 'center', 
            modal: true,
            buttons: buttons            
    });    
}

function goToUserPage(userId)
{
    var loc = "www.wishlist.com/user/"+id;
    window.location = loc;
}  
 
 
       
        


