/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var userName;
var userID;

$(document).ready(function(){   
   $("#linkList").menu();
  // $("#mainProfileLink").removeClass("ui-menu-item");

       
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
    
    userName = $("#hi_username").val();    
    userID = $("#hi_id").val();
    
    $("#userNameLink").html(userName);
});

function showOnlyMainProfileLink()
{
   $("#linkList li").hide();
   $("#mainProfileLink").show();    
}
