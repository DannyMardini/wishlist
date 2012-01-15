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

$(document).ready(function(){
        
    $.ajaxSetup ({  
        cache: false  
    });

});


function setupItemView(data)
{
    $('#itemDialog').attr('title','Wishlist Item');

    $('#itemDialog #name').html(data.name);
    $('#itemDialog #price').html(data.price);
    $('#itemDialog #link').html('<a target="_blank" href="http://'+data.link+'">link</a>');
      
/*
     *
     *  $("#DivPassword")
        .dialog('open');
     **/   
    
    
    // create dialog
    $( "#itemDialog" ).dialog({
            position: 'center', 
            resizable: false,
            height:200,
            width:500,
            modal: true

    });  
    
    $("<div id='AddToWishlist' style='margin-right:10px;text-align:left;padding-left:0px;font-size:12px;position:absolute;bottom:0px;right:0px;width:30px;height:25px;'>test tooltip</div>")
    .button({
        icons: {
            primary: 'ui-icon-cart'
        },
        text: false            
    })
    .click(function (event) {
        alert('adds this item to your cart TODO');
    }).appendTo($( "#itemDialog" ));
    
    $("#AddToWishlist").tooltip({
        fadeInSpeed: 10,
        // change trigger opacity slowly to 0.8
        onShow: function() {
                this.getTrigger().fadeTo("slow", 0.8);
        }

    });   
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
 
 
       
        


