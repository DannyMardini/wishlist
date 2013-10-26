/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    
    $.ajaxSetup ({  
        cache: false  
    });
    
});

function populateEvent(event)
{
    var eventType = event.event_type;
    var div = eventType == 1 ? $('#birthdays') : (eventType == 4 ? $('#anniversaries') : null);
    
    if(div)
    {
        var eventDiv = $("<div/>").attr('id',event.id).html(event.eventdate);
        $(div).append(eventDiv);
    }
}

function goToUserPage(userId)
{
    var loc = "www.wishlist.com/User";
    window.location = loc;
}

function fillPic(item)
{
    var picContainer = $(item).children('span.picContainer');
    var query = $(item).children('label').html();
    
    fillGoogleImage(query, picContainer);
}

function fillGoogleImage(query, picContainer)
{
    var mykey = "AIzaSyBHtgh3ihz8AHCBw0LkEi_Snl96elJCSpA";
    var cx = "015228749791243702187:ctequifxi_s";
    var hndlr = "googleQryHndlr";
    var url = "https://www.googleapis.com/customsearch/v1?key="+mykey+"&cx="+cx+"&q="+query+"&searchType=image&num=1";
    
    $.get(url, function(response) {fillPicContainer(picContainer, response)}, "json");
}

function fillPicContainer(picContainer, response)
{
    picContainer.html( function(index, oldhtml){
        var newhtml = '';
        
        if (response.items.length > 0)
        {
            var item = response.items[0];
            newhtml += "<img class='itemThumb' src='"+item.link+"' />";
        }
        
        return newhtml;
    });
}
