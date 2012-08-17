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
        var location = $(this).attr('href');
        if(location == '#') return false;
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
        $("#dropDownButton").removeClass('selected');
        rightPanelVisible = 0;
      }else 
      {
        $("#dropDownMenu").show();
        $("#dropDownButton").addClass('selected');
        rightPanelVisible = 1;
      }
    });

    $("#userName").click(function(){
        window.location = $('#userNameLink').attr('href');
    });

    $('.ui-MenuLink').bind('click', function(){
        navigate($(["#", $(this).attr('id'), "Path"].join('')).val());
    });
});

function showOnlyMainProfileLink()
{
   $("#linkList li").hide();
   $("#mainProfileLink").show();
}

function navigate(path)
{
    window.location = path;
}
