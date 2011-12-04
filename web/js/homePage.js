/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var userName;
var userID;

$(document).ready(function(){   
   $("#linkList").menu();
  // $("#mainProfileLink").removeClass("ui-menu-item");

$("#test").text($("#test").text().substr(0,1).toUpperCase()+$("#test").text().substr(1,$("#test").text().length));

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
