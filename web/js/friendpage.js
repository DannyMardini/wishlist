function updateFriendList(friends)
{
    var friendlist = $('#friendlist ul');
    
    //Empty out the friendlist
    friendlist.empty();

    //Fill in the new friendlist with new friends 
    for( var i = 0; i < friends.length; i++)
    {
        //friendlist.append("<li>" + friends[i].firstName + " "+ friends[i].lastName + "</li>");
        friendlist.append("<li><img class='friendIcon' src='" + friends[i].profileUrl + "'/><a href='" + Routing.generate('WishlistUserBundle_userpage', {user_id: friends[i].wishlistuser_id}) +"'>" + friends[i].firstName + " " + friends[i].lastName +"</a></li>");
    }
    
    //Finally make all of the newly created search results into button links.
    createButtonLinks();
}

function filterFriends(e)
{
    var filterTerm = $('#friendSearch').val();

    if( e.keyCode == 13 )
    {
        $.ajax({
            type: 'POST',
            url: '/app_dev.php/FriendSearch',
            data: { searchTerm: filterTerm },
            success: function(data, textStatus, jqXHR) {
                updateFriendList(jQuery.parseJSON(data));
            }
        });
    }
}

function createButtonLinks()
{
    $('#friendlist ul li').click(function(){
       window.location = $(this).find("a").attr("href");
    });    
}

$(document).ready(function(){
    
    createButtonLinks();
    
    $('#friendSearch').keyup(filterFriends);
});