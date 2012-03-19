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
            var paramArray = new Array(encodeURIComponent($("#newWishName").val()), $("#newWishPrice").val(), encodeURIComponent($("#newWishLink").val()));
            addToWishlist(paramArray, setupWishlist);
        }
    });

    $("h3 .ui-icon-close").click(function(e){
        $(wishlist_div).accordion( "option", "disabled", true);
        delFromWishlist($(this).next().text(), setupWishlist);
    });
}


$(document).ready(function(){
    setupWishlist();
});