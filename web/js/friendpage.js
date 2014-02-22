var searchTimeout = 0.5; //timeout for search box in seconds.
var timer = 0;

function searchFriends()
{
    var searchTerm = $('#friendSearch').val();
    
    //make the ajax call to search for friends.
    $.ajax({
        type: 'POST',
        url: Routing.generate('WishlistUserBundle_friendSearch'),
        data: {searchTerm: searchTerm},
        success: function(data, textStatus, jqXHR) {
            updateFriendList(jQuery.parseJSON(data));
        }
    });   
}

function timerEnd()
{
    window.clearTimeout(timer);
}

function timerRestart()
{
    timerEnd();
    timer = window.setTimeout(searchFriends, searchTimeout*1000);
}

function modifyAddButton(response, textStatus, jqXHR, row)
{
    console.log('Promoting friend!');    
    $('.addFriendButtonDiv',row).fadeOut(400, function(){
        $(this).html("Request sent").addClass("requestSentNotification");
        $(this).fadeIn(400);
    });
}

function addFriend(personId)
{
    var row = $("input.userId[value|='"+ personId + "']").parent();
    ajaxPost({personId: personId}, Routing.generate('WishlistUserBundle_friendAdd'), modifyAddButton, row);
}

function updateFriendList(results)
{
    var friends = results.friends;
    var persons = results.persons;
    var friendlist = $('div.friendlist');
   
    if(friendlist.size() == 0)
    {
        $('#friendsContainer').append('<div class="friendlist"></div>');
        friendlist = $('div.friendlist');
        friendlist.addClass('friendlist');
    }
    //Empty out the whole friendlist
    friendlist.empty();

    //TODO: This HTML is a hack, it should really be moved to the server.
    if( friends.length >= 1 ) {
        var friendRowArray = [];
        friendlist.append('<div id="friendSeparator" class="listSeparator">My Friends</div><div id="div_friendlist_div"><ul></ul></div>');
        
        friends.forEach(function(friend) {
            friendRowArray.push("<li><div class='userButton'><img class='friendIcon' src='" + friend.profileUrl + "'/><a href='" + Routing.generate('WishlistUserBundle_userpage', {user_id: friend.wishlistuser_id}) +"'>" + friend.name +"</a></div></li>");
        });
        
        $('#div_friendlist_div ul').append(friendRowArray.join(""));
    }
    
    if( persons.length >= 1) {
        var personRowArray = [];
        friendlist.append('<div id="peopleSeparator" class="listSeparator">People on Wishenda</div><div id="div_personlist_div"><ul></ul></div>');
        
        persons.forEach(function(person) {
            personRowArray.push("<li>" 
                                + "<input class='userId' type='hidden' value='"+ person.wishlistuser_id + "' />"
                                + "<div class='addFriendButtonDiv'>"
                                    + "<button class='addFriendButton'>Add Friend</button>"
                                + "</div>"
                                + "<div class='userButton'>"
                                    + "<img class='friendIcon' src='" + person.profileUrl + "'/>"
                                    + "<a href='" + Routing.generate('WishlistUserBundle_userpage', {user_id: person.wishlistuser_id}) +"'></a>"
                                    + person.name
                                + "</div>"
                                + "</li>");
        });
        
        $('#div_personlist_div ul').append(personRowArray.join(""));
        $('.addFriendButton').button({
            icons: {
                primary: "ui-icon-plusthick"
            }
        }).click(function(e){
            var userRow = $(this).parents("li");
            var personId = userRow.children("input.userId").val();
            addFriend(personId);
        });
    }
    
    //Finally make all of the newly created search results into button links.
    createButtonLinks();
}

function keyTrigger(e)
{
    if( (e.keyCode >= 65 && e.keyCode <= 90) || e.keyCode === 8 || e.keyCode === 16)
    {
        //if it was a normal character just restart the timer for the search.
        timerRestart();
    }
    else if( e.keyCode === 13 )
    {
        //If enter was pressed cancel the timer and search for friends.
        timerEnd();
        searchFriends();
    }
    else {
        var val = removeSpecialChars($(e.srcElement).val());
        $(e.srcElement).val(val);
    }
}

function createButtonLinks()
{
    $('.userButton').click(function(){
       window.location = $(this).find("a").attr("href");
    });
    
    $('#addFriendButton').button();    
    $('#addFriendButton').css('height', '30').css('font-size','10');
    
    $('#inviteFriendButton').button();    
    $('#inviteFriendButton').css('height', '30').css('font-size','10');    
}

function displayFriendInviteStatus(inviteStatus)
{
    var title = '';
    var message = '';

    if(true == inviteStatus) {
        title = 'Success';
        message = 'Your friend has been invited to Wishenda!';
    }
    else {
        title = 'Failure';
        message = 'A problem occurred, is your friend already a member of Wishenda?';
    }
    
    popupMessage(title, message);
}

function submitFriendInvite(email)
{
    var retval = false;
    var inviteUrl = Routing.generate('WishlistUserBundle_friendInvite');

    ajaxPost({email: email}, inviteUrl, function(responseText) {
        if (responseText.toLowerCase() == 'success') {
            retval = true;
        }
        else {
            retval = false;
        }
        
        displayFriendInviteStatus(retval);
        $('#friendInviteDialog').dialog('close');
    });
}

$(document).ready(function(){
    var friendInviteDialog = $('#friendInviteDialog');
    var friendInviteEmail = $('#newFriendEmail');
    
    createButtonLinks();
    
    $('#friendSearch').keyup(keyTrigger);

    friendInviteDialog.dialog({
            autoOpen: false,
            position: 'top', 
            resizable: false,
            height:300,
            width:500,
            modal: true,
            buttons: {
                'Invite': function(){
                    $('#friendInviteFormSubmit').click();
                }
            }
    });
    
    $('#friendInviteForm').submit(function(e) {
        e.preventDefault();
        
        submitFriendInvite(friendInviteEmail.val());
    });
    
    $('#inviteFriendButton').click(function(){
        friendInviteDialog.dialog('open');
        friendInviteEmail.val('');
    });
});
