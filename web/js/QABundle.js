$(document).ready(function(){
    
   $('.subTopic').click(onClickMenuSubOption);
   $('.contentInfoTopic').click(onClickContentTopic);
   
});

function onClickMenuSubOption(event)
{
   $(this).addClass('currentSelection').siblings().removeClass('currentSelection');   
    //var liObj = event.target; 
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

