/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var wishlist_div = "#div_wishlist_div";

function setupWishlist()
{
    $(wishlist_div).accordion({
        collapsible: true,
        active: false
    });

    $(wishlist_div).keyup(function(e) {
        if(e.keyCode === 13 )
        {
            e.preventDefault();
            addToWishlist({newWishName: $("#newWishName").val(), newWishPrice: $("#newWishPrice").val(), newWishLink: $("#newWishLink").val()}, setupWishlist);
        }
    });

    $("h3 .ui-icon-close").click(function(e){
        $(wishlist_div).accordion( "option", "disabled", true);
        delFromWishlist({delWishName: $(this).next().text()}, setupWishlist);
    });
}


$(document).ready(function(){
    setupWishlist();
});