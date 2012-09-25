/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var userName;
var userID;
var rightPanelVisible = 0;

$(document).ready(function(){
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
