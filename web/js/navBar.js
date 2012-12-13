/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var userName;
var userID;
var rightPanelVisible = 0;

window.history.forward();

function noBack() { 
    window.history.forward(); 
}

$(document).ready(function(){
    showOnlyMainProfileLink();
    
    $('#logoutLink').click(onLogoutClickEvent);

    $("#dropDownButton").click(function(){
      if( rightPanelVisible )
      {
        $('#dropDownMenu').hide();
        $("#dropDownButton").removeClass('selected');
        rightPanelVisible = 0;
      }
      else
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

       function noBack()
         {
             window.history.forward()
         }

function onLogoutClickEvent()
{
    navigate($('#frontpageLinkPath').val());
}

function showOnlyMainProfileLink()
{
   $("#linkList li").hide();
   $("#mainProfileLink").show();
}

function navigate(path)
{
    if(path)
    {
        window.location = path;
    }
}
