/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var userName;
var userID;
var rightPanelVisible = 0;

$(document).ready(function(){

    $("#linkList").menu();

    $("a").click(function(){
        $(this).blur();
        window.location = $(this).attr('href');
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

    $("#friend_button").click(function(){
      if( rightPanelVisible )
      {
        $('#rightPanel').hide();
        rightPanelVisible = 0;
      }else 
      {
        $("#rightPanel").show();
        rightPanelVisible = 1;
      }
    });

});

function showOnlyMainProfileLink()
{
   $("#linkList li").hide();
   $("#mainProfileLink").show();
}
