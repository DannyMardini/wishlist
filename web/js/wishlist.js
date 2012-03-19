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
            var wishlistdiv = $('#wishlist');
            e.preventDefault();
            var paramArray = new Array(encodeURIComponent($("#newWishName").val()), $("#newWishPrice").val(), encodeURIComponent($("#newWishLink").val()));
            addToWishlist(paramArray, setupWishlist, $(wishlistdiv));
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