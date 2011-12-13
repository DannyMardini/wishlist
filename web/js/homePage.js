/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var userName;
var userID;

$(document).ready(function(){  
    
    $("#linkList").menu();

    userName = $("#username").val().substr(0,1).toUpperCase()+$("#username").val().substr(1, $("#username").val().length);    
    userID = $("#id").val();

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
