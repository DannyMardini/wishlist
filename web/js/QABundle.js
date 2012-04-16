$(document).ready(function(){
    
   $('.subTopic').click(onClickMenuSubOption);
   
});

function onBlurMenuSubOption(event){
   alert('blur');
}

function onClickMenuSubOption(event)
{
   $(this).addClass("currentSelection").siblings().removeClass("currentSelection");
   // alert('test');
    
    //var liObj = event.target;
 
}

