function updateFriendList(friends)
{
    var friendlist = $('#friendlist ul');
    
    //Empty out the friendlist
    friendlist.empty();

    //Fill in the new friendlist with new friends 
    for( var i = 0; i < friends.length; i++)
    {
        friendlist.append("<li>" + friends[i].firstname + " "+ friends[i].lastname + "</li>"); 
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
                console.log("Status: " + textStatus);
                console.log("data: " + data);
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