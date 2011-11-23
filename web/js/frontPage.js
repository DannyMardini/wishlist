

$(document).ready(function()
{   
    setupCSS();
        
    
    // hide toggle windows
    hideToggleWindows();
    
    // hover effects
    $('#requestInviteButton, #loginButton, #submitRequestInvite, #submitLogin').hover(
            function() {$(this).addClass('ui-state-hover');}, 
            function() {$(this).removeClass('ui-state-hover');}
     ); 
         
    $('#submitRequestInvite').click(function(){
        
    });   
                 
    // set effect from select button
    $("#requestInviteButton, #loginButton, #loginLink").click(function() {
        var thisId = $(this).attr('id');
        var activeToggler_SelectorId = "";
        var hiddenToggler_SelectorId = "";

        if(thisId == "requestInviteButton")
        {
            activeToggler_SelectorId = "#requestInviteToggleWindow";
            hiddenToggler_SelectorId = "#loginToggleWindow";
        }
        else{
            activeToggler_SelectorId = "#loginToggleWindow";
            hiddenToggler_SelectorId = "#requestInviteToggleWindow";
        }
                                                
        $(hiddenToggler_SelectorId).hide();        
        runEffect(activeToggler_SelectorId);        
    }); 

});


function setupCSS()
{
    $(':input').addClass("ui-state-default");
    $(':input').addClass("ui-corner-all");
    
    $('#requestInviteButton, #loginButton').addClass("ui-state-default");
    $('#requestInviteButton, #loginButton').addClass("ui-corner-all");
}


// hide the toggle windows
function hideToggleWindows()
{
    $('#requestInviteToggleWindow').hide();
    $('#loginToggleWindow').hide();        
}


// run the currently selected effect
function runEffect(togglerWindow) {        
        $(togglerWindow ).show( "slide",{direction: "left"}, 1500);
};     

