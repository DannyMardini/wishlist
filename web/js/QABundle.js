
$(document).ready(function(){
    
   $('.subTopic').click(onClickMenuSubOption);   
   $('.subTopic').hover(function(){
       appendIcon(this);
   },function(){
       $('.silverDot',this).remove();
       appendIcon($('.currentSelection'));
   });
   
   //$('.contentInfoTopic', $('.contentInfo')).click(onClickContentTopic);

   preSelectMenuSubOption();
});

function appendIcon(option)
{
    if($('.silverDot',option).length <= 0)
    {
        $(option).append("<img class='silverDot' style='padding-left:15px;' src='/images/silverdot.gif' width='12px' height='12px' />");
        $('.silverDot', $(option).siblings()).remove();
    }
}

function preSelectMenuSubOption(){
    selectMenuSubOption('.topic'+$('#selectedOptionIndex').val());
}

function onClickMenuSubOption()
{
   selectMenuSubOption(this);
   $('.contentInfo').load($(this).attr('id'));
    $('.contentInfoTopic', $('.contentInfo')).click(onClickContentTopic);
}

function selectMenuSubOption(option)
{
   $(option).addClass('currentSelection').siblings().removeClass('currentSelection');  
   
   if($('.silverDot',option).length <= 0)
   {
        $(option).append("<img class='silverDot' style='padding-left:15px;' src='/images/silverdot.gif' width='12px' height='12px' />");
        $('.silverDot', $(option).siblings()).remove();
   }
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

