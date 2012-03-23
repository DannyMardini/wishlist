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
            var itemObj = {name: encodeURIComponent($("#newWishName").val()), price: $("#newWishPrice").val(), link: encodeURIComponent($("#newWishLink").val())};
            addToWishlist(itemObj, setupWishlist);
        }
    });

    $("h3 .ui-icon-close").click(function(e){
        $(wishlist_div).accordion( "option", "disabled", true);
        delFromWishlist(encodeURIComponent($(this).next().text()), setupWishlist);
    });
}


$(document).ready(function(){
    setupWishlist();
});