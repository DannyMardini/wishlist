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

    $("h3 .ui-icon-close").click(function(e){
        $(wishlist_div).accordion( "option", "disabled", true);
        $( "#wishlist" ).load('/wishlist/delete', {delWishName: $(this).next().text()}, function(){
            setupWishlist(wishlist_div);
        });

    $(wishlist_div).attr("style", "width=")
    });
}

$(document).ready(function(){
    setupWishlist("#div_wishlist_div");
});