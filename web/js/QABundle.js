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
    $(this).next().addClass('displayContentInfo').siblings().removeClass('displayContentInfo');
}

