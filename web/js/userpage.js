function unfriendUser(event) {
    var userid = parseInt($('#userId').val(), 10);
    var homepageRedirect = function() { window.location = Routing.generate('WishlistUserBundle_homepage') };

    ajaxPost({userid: userid}, Routing.generate('WishlistUserBundle_unfriend'), function(data, textStatus) {
        if(data.toLowerCase() == 'success') {
            popupMessage('Success', 'User successfully unfriended.', homepageRedirect);
        } 
        else {
            popupMessage('Failure', 'An unexpected error occurred, please try again later.');
        }
    });
}

$(document).ready(function() {
    $('#unfriendButton').click(unfriendUser);
});
