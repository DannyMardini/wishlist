$(document).ready(function(){
    
   
   
});

function onClickMenuSubOption(event)
{
    var liObj = event.target;
    var currColor = $(liObj).css('background-color');
    if(currColor == 'pink')
    {
        $(liObj).css('background-color', '#999999');
    }
    else
    {
        $(liObj).css('background-color', 'pink');
    }
    
}

