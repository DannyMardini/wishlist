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