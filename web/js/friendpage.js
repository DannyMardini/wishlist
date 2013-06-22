var searchTimeout = 0.5; //timeout for search box in seconds.
var timer = 0;

function searchFriends()
{
    var searchTerm = $('#friendSearch').val();
    
    //make the ajax call to search for friends.
    $.ajax({
        type: 'POST',
        url: '/app_dev.php/FriendSearch',
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

function promoteToFriend(response, row)
{
    console.log('Promoting friend!');    
    $('.addFriendButtonDiv',row).fadeOut(400, function(){
        $(this).detach('.addFriendButtonDiv');
        $(row).detach();
        $('#div_friendlist_div ul').append(row);
    });
}

function addFriend(personId)
{
    var row = $("input.userId[value|='"+ personId + "']").parent();
    ajaxPost({personId: personId}, '/app_dev.php/FriendAdd', promoteToFriend, row);
}

function updateFriendList(results)
{
    var friends = results.friends;
    var persons = results.persons;
    var friendlist = $('#friendlist');
    
    //Empty out the whole friendlist
    friendlist.empty();

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
        friendlist.append('<div id="peopleSeparator" class="listSeparator">People</div><div id="div_personlist_div"><ul></ul></div>');
        
        persons.forEach(function(person) {
            personRowArray.push("<li><input class='userId' type='hidden' value='"+ person.wishlistuser_id + "' /><div class='addFriendButtonDiv'><button class='addFriendButton'>Add Friend</button></div><div class='userButton'><img class='friendIcon' src='" + person.profileUrl + "'/><a href='" + Routing.generate('WishlistUserBundle_userpage', {user_id: person.wishlistuser_id}) +"'>" + person.name + "</a></div></li>");
        });
        
        $('#div_personlist_div ul').append(personRowArray.join(""));
        $('.addFriendButton').button({
            icons: {
                primary: "ui-icon-plusthick"
            }
        }).click(function(e){
            addFriend(personId);
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
    if( (e.keyCode >= 65 && e.keyCode <= 90) || e.keyCode == 8 )
    {
        //if it was a normal character just restart the timer for the search.
        timerRestart();
    }
    else if( e.keyCode == 13 )
    {
        //If enter was pressed cancel the timer and search for friends.
        timerEnd();
        searchFriends();
    }
}

function createButtonLinks()
{
    $('.userButton').click(function(){
       window.location = $(this).find("a").attr("href");
    });    
}

$(document).ready(function(){
    
    createButtonLinks();
    
    $('#friendSearch').keyup(keyTrigger);
});