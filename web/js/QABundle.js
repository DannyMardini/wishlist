
$(document).ready(function(){
    
   $('.subTopic').click(onClickMenuSubOption);
   $('.contentInfoTopic').click(onClickContentTopic);
   preSelectMenuOption();
});

function preSelectMenuOption(){
    //var selectedIndex = $('#selectedOptionIndex').val().replace(/\./g, "\\\\\.").replace(/\//g,"\\\\\/");
    var selectedIndex = '.topic'+$('#selectedOptionIndex').val();
    selectMenuSubOption(selectedIndex);
}

function onClickMenuSubOption()
{
   selectMenuSubOption(this);
   redirectTo($(this).attr('id'));
    //var liObj = event.target; 
}

function selectMenuSubOption(option)
{
   $(option).addClass('currentSelection').siblings().removeClass('currentSelection');  
   
   $(option).append("<img style='padding-left:15px;' src='/images/silverdot.gif' width='12px' height='12px' />");
}

function redirectTo(url)
{
    document.location.href = url;
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

