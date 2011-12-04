/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

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
});

function showOnlyMainProfileLink()
{
   $("#linkList li").hide();
   $("#mainProfileLink").show();    
}
