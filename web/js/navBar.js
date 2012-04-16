/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var userName;
var userID;
var rightPanelVisible = 0;

$(document).ready(function(){

//    $("#linkList").menu();

    $("a").click(function(){
        $(this).blur();
        window.location = $(this).attr('href');
    });

    //When mouse rolls over
//    $("#linkList").mouseover(function(){
//        $("#linkList li").show();
//    });
//
//    //When mouse is removed
//    $("#linkList").mouseout(function(){
//        showOnlyMainProfileLink();
//    });
//
    showOnlyMainProfileLink();

    $("#dropDownButton").click(function(){
      if( rightPanelVisible )
      {
        $('#dropDownMenu').hide();
        rightPanelVisible = 0;
      }else 
      {
        $("#dropDownMenu").show();
        rightPanelVisible = 1;
      }
    });

    $("#userName").click(function(){
        window.location = $('#userNameLink').attr('href');
    });

});

function showOnlyMainProfileLink()
{
   $("#linkList li").hide();
   $("#mainProfileLink").show();
}
