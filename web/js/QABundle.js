
$(document).ready(function(){
    
   $('.subTopic').click(onClickMenuSubOption);   
   $('.subTopic').hover(function(){
       appendIcon(this);
   },function(){
       $('.silverDot',this).remove();
       appendIcon($('.currentSelection'));
   });
   
   $('#goBack').click(goBackToPrevPage);

   preSelectMenuSubOption();
});

function goBackToPrevPage()
{
     history.back();
}

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

