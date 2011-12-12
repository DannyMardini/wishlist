/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var userName;
var userID;

$(document).ready(function(){  
    
    $( "#accordion" ).accordion({
			event: "mouseover",
                        $(this).animate({width: maxWidth+"px"}, { queue:false, duration:400})
	
		});
    
    $("#linkList").menu();
    // $("#mainProfileLink").removeClass("ui-menu-item");

    userName = $("#hi_username").val().substr(0,1).toUpperCase()+$("#hi_username").val().substr(1, $("#hi_username").val().length);    
    userID = $("#hi_id").val();

    $("#userNameLink").html(userName);

    $("a").click(function(){
        $(this).blur();
    });

    //When mouse rolls over
    $("#linkList").mouseover(function(){            
        $("#linkList li").show();
    });

    //When mouse is removed
    $("#linkList").mouseout(function(){            
        showOnlyMainProfileLink();
    });

    showOnlyMainProfileLink();        
});

function showOnlyMainProfileLink()
{
   $("#linkList li").hide();
   $("#mainProfileLink").show();    
}
