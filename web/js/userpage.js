function unfriendUser(event) {
    var userid = parseInt($('#userId').val(), 10);
    var homepageRedirect = function() { window.location = Routing.generate('WishlistUserBundle_homepage') };

    // confirm that this is what the user wants to do
    confirm('Are you sure you want to remove this friend?')
    .then(function (answer) {//then will run if 1 (Yes) or 0 (No) is clicked
        if(answer == 1) // 1 means continue
        {
            ajaxPost({userid: userid}, Routing.generate('WishlistUserBundle_unfriend'), function(data, textStatus) {
                if(data.toLowerCase() == 'success') {
                    popupMessage('Success', 'User successfully unfriended.', homepageRedirect);
                } 
                else {
                    popupMessage('Failure', 'An unexpected error occurred, please try again later.');
                }
            });
        }
    });
}

$(document).ready(function() {
    $('#unfriendButton').click(unfriendUser);
});
