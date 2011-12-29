/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var userName;
var userID;

$(document).ready(function(){

    $("#linkList").menu();

    $("a").click(function(){
        $(this).blur();
        window.location = $(this).attr('href');
    });

    //When mouse rolls over
    $("#linkList").mouseover(function(){
        $("#linkList li").show();
    });

    //When mouse is removed
    $("#linkList").mouseout(function(){
        showOnlyMainProfileLink();
    });

    showOnlyMainProfileLink();
});

function showOnlyMainProfileLink()
{
   $("#linkList li").hide();
   $("#mainProfileLink").show();
}
