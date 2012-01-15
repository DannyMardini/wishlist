/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function setupWishlist(wishlist_div)
{
    $(wishlist_div).accordion({
        collapsible: true,
        active: false
    });

    $(wishlist_div).keyup(function(e) {
        if(e.keyCode === 13 )
        {
            e.preventDefault();

            $( "#wishlist" ).load('/wishlist/new', {newWishName: $("#newWishName").val(), newWishPrice: $("#newWishPrice").val(), newWishLink: $("#newWishLink").val()}, function(){
              setupWishlist(wishlist_div);
            });
        }
    });
}

$(document).ready(function(){
    setupWishlist("#div_wishlist_div");
});