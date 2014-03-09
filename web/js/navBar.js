var userName;
var userID;
var dropDowns = ['#accountOptionsDropdown', '#notificationWindow', '#updatesComponent'];

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

/* Hide the notifications drop down once the user has responded to all of the notifications */
function removeNotification(notification)
{
    notification.fadeOut(400, function(){
        notification.remove();
        removeNotificationHelper();
    });
}

function ignoreFriendClicked()
{
    var parentLi = $(this).parent().parent().parent();
    var num = getNotificationNumber(parentLi);
    ajaxPost(null, Routing.generate('WishlistUserBundle_ignoreFriendRequest', {notificationId: num}), null, null);
}

function acceptFriendClicked()
{
    var parentLi = $(this).parent().parent().parent();
    var num = getNotificationNumber(parentLi);
    ajaxPost(null, Routing.generate('WishlistUserBundle_acceptFriendRequest', {notificationId: num}), null, null);
}

/* Navigates to the frontpage and logs the user out */
function onLogoutClickEvent() {
    ajaxPost({}, Routing.generate('WishlistFrontpageBundle_logout'), function(data, textStatus){
        navigate($('#frontpageLinkPath').val());
    });
}

function navButtonClicked(obj, id) {
    if($(obj).hasClass('selectedNavButton')) {
        $(id).hide();
        $(obj).removeClass('selectedNavButton');
    }
    else {
        hideOpenDropDowns();
        $(id).show();
        $(obj).addClass('selectedNavButton');
    }
}

function blurNavigationButton(obj)
{
    if(!$(obj).hasClass('selectedNavButton')){
        $(obj).blur();
    }    
}

$(document).ready(function () {
    $('#logoutLink').click(onLogoutClickEvent);

    $('.navButton')
    .click(function () {
        navButtonClicked(this, ("#"+$(this).attr('for')) );
    })
    .mouseout(function(){
        blurNavigationButton(this);
    });

    $("a.acceptFriend").click(acceptFriendClicked);
    $("a.ignoreFriend").click(ignoreFriendClicked);

    $('.ui-MenuLink').bind('click', function () {
        navigate($(["#", $(this).attr('id'), "Path"].join('')).val());
    });

    // hides the friend request after an option was clicked by the user. (accept or ignore)
    $(".notifications a").click(function () {
        removeNotification($(this).parent().parent().parent());
    });
});

function hideOpenDropDowns(){    
    $('.navBarComponent').hide();
    $('.navButton').removeClass('selectedNavButton');
}

function getNotificationNumber(notification)
{
    var stringArray = notification.attr("id").split('_');
    if(stringArray.length > 1)
    {
        return stringArray[1];
    }
}

function navigate(path)
{
    if(path)
    {
        window.location = path;
    }
}
