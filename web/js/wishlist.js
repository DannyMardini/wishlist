/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){

    $( "#div_wishlist_div" ).accordion({
        collapsible: true,
        active: false
    });

    $( "#newWishForm" ).submit(function(e) {
        e.preventDefault();

        $.post('/wishlist/new', $("#newWishForm").serialize());
    });
});