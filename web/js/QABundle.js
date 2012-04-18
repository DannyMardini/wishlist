$(document).ready(function(){
    
   $('.subTopic').click(onClickMenuSubOption);
   $('.contentInfoTopic').click(onClickContentTopic);
   
});

function onClickMenuSubOption(event)
{
   $(this).addClass('currentSelection').siblings().removeClass('currentSelection');
   redirectTo($(this).attr('id'));
    //var liObj = event.target; 
}

function redirectTo(url)
{
    window.open(url, 'help');
}

function onClickContentTopic(event){    
    
    if(!$(this).next().hasClass('displayContentInfo')){
        $(this).next().addClass('displayContentInfo');
    }
    else
    {
        $(this).next().removeClass('displayContentInfo');
    }
}

