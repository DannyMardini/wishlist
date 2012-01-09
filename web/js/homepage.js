/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {      
    
//    $('.Update .message a').click(function(){
//        openDialog();
//        return false;
//    });    
});

function openDialog(itemId)
{
    $( "#testDialog" ).dialog({
            position: 'center', 
            modal: true,
            buttons: {
                    Ok: function() {
                            $( this ).dialog( "close" );
                    }
            }
    });    
}

function goToUserPage(userId)
{
    var loc = "www.wishlist.com/user/"+id;
    window.location = loc;
}  
 
 
       
        


