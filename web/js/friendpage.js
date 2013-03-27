function updateFriendList(friends)
{
    var friendlist = $('#friendlist ul');
    
    //Empty out the friendlist
    friendlist.empty();

    //Fill in the new friendlist with new friends 
    for( var i = 0; i < friends.length; i++)
    {
        //friendlist.append("<li>" + friends[i].firstName + " "+ friends[i].lastName + "</li>");
        console.log("<li><img class='friendIcon' src='" + friends[i].profileUrl + "'/><a href='/app_dev.php/Friendpage/"+ friends[i].wishlistuser_id +"'>" + friends[i].firstName + " " + friends[i].lastName +"</a></li>");
        friendlist.append("<li><img class='friendIcon' src='" + friends[i].profileUrl + "'/><a href='/app_dev.php/User/"+ friends[i].wishlistuser_id +"'>" + friends[i].firstName + " " + friends[i].lastName +"</a></li>");
    }
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

$(document).ready(function(){
    
    $('#friendlist ul li').click(function(){
       window.location = $(this).find("a").attr("href");
    });
    
    $('#friendSearch').keyup(filterFriends);
});