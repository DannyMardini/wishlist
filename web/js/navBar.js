/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var userName;
var userID;

window.history.forward();

function noBack() { 
    window.history.forward(); 
}

$(document).ready(function(){
    showOnlyMainProfileLink();
    
    $('#logoutLink').click(onLogoutClickEvent);

    $('#dropDownButton').click(function(){
        if( $(this).hasClass('selected') )
        {
            $('#dropDownMenu').hide();
            $(this).removeClass('selected');
        }
        else
        {
            $('#dropDownMenu').show();
            $(this).addClass('selected');
        }
    });

    $('#notificationDiv').click(function(){
        if( $(this).hasClass('selected') )
        {
            $('#notificationWindow').hide();
            $(this).removeClass('selected');
        }
        else
        {
            $('#notificationWindow').show();
            $(this).addClass('selected');
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
