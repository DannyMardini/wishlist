var userName;
var userID;
var dropDowns = ['#accountOptionsDropdown', '#notificationWindow', '#updatesComponent'];

//window.history.forward();

//function noBack() { 
//    window.history.forward(); 
//}

$( window ).resize(function() {
  resizeHeaderDropDownContainer();
});

$(document).ready(function(){
    $('#logoutLink').click(onLogoutClickEvent);

    $('#accountOptionsDropdownButton').click(function(){
        navButtonClicked(this, '#accountOptionsDropdown');
        resizeHeaderDropDownContainer();
    });

    $('#viewNotificationsButton').click(function(){
        navButtonClicked(this,'#notificationWindow');
    });
    
    $('#updatesWindowButton').click(function(){
        navButtonClicked(this, '#updatesComponent');
    });

    $("a.acceptFriend").click(acceptFriendClicked);
    $("a.ignoreFriend").click(ignoreFriendClicked);

    $('.ui-MenuLink').bind('click', function(){
        navigate($(["#", $(this).attr('id'), "Path"].join('')).val());
    });

    $(".notifications a").click(function(){
        removeNotification($(this).parent());
    });
});

function navButtonClicked(obj, id){
    if($(obj).hasClass('selected')) {
        $(id).hide()
        $(obj).removeClass('selected');
    }
    else {
        hideOpenDropDowns();
        $(id).show();
        $(obj).addClass('selected');
    }
}

function resizeHeaderDropDownContainer()
{
    // the drop down options container should be positioned to 
    // the same position as the drop down button 
    var buttonLeftPosition = $('#accountOptionsDropdownButton').offset().left;
    $('#accountOptionsDropdown').css('left', buttonLeftPosition - 144);    
}

function hideOpenDropDowns(){
    $('#accountOptionsDropdown').hide();
    $('#notificationWindow').hide();
    $('#updatesComponent').hide();
    $('#navigation li.selected').removeClass('selected');
}

function getNotificationNumber(notification)
{
    var stringArray = notification.attr("id").split('_');
    if(stringArray.length > 1)
    {
        return stringArray[1];
    }
}

function acceptFriendClicked()
{
    var parentLi = $(this).parent();
    var num = getNotificationNumber(parentLi);
    ajaxPost(null, Routing.generate('WishlistUserBundle_acceptFriendRequest', {notificationId: num}), null, null);
}

function ignoreFriendClicked()
{
    var parentLi = $(this).parent();
    var num = getNotificationNumber(parentLi);
    ajaxPost(null, Routing.generate('WishlistUserBundle_ignoreFriendRequest', {notificationId: num}), null, null);
}

/* Hide the notifications drop down once the user has responded to all of the notifications */
function removeNotification(notification)
{
    notification.fadeOut(400, function(){
        notification.remove();
        removeNotificationHelper();
    });
}

/* Helper method for removeNotification */
function removeNotificationHelper()
{
    var notsRemaining = $('#notificationWindow li').size();
    if(notsRemaining <= 0)
    {
        $('#notificationDiv').fadeOut(400, function(){$(this).remove()});
        $('#notificationsDropDown').remove();
    }
}

/* Navigates to the frontpage and logs the user out */
function onLogoutClickEvent()
{
    ajaxPost({}, Routing.generate('WishlistFrontpageBundle_logout'), function(data, textStatus){
        navigate($('#frontpageLinkPath').val());
    });
}

function navigate(path)
{
    if(path)
    {
        window.location = path;
    }
}
