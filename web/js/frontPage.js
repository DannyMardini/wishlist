
var togglerIsExpanded = false;
var togglerTimeoutTime = 100;

$(document).ready(function()
{   
    // hide toggle windows
    hideToggleWindows();
    
    // hover effects
    $('#requestInviteButton, #loginButton').hover(
            function() { $(this).addClass('ui-state-hover'); }, 
            function() { $(this).removeClass('ui-state-hover'); }
     );         
                 
    // set effect from select button
    $("#requestInviteButton, #loginButton").click(function() {
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
                            
            
        if(togglerIsExpanded)
        {
            $(hiddenToggler_SelectorId).hide("clip",{ direction: "horizontal" },500);
            togglerTimeoutTime = 1000;
        }
        
        setTimeout('runEffect("' + activeToggler_SelectorId + '");', togglerTimeoutTime);
        togglerIsExpanded = true;
    }); 

});

// hide the toggle windows
function hideToggleWindows()
{
    $('#requestInviteToggleWindow').hide();
    $('#loginToggleWindow').hide();        
}


// run the currently selected effect
function runEffect(togglerWindow) {        
        $(togglerWindow ).show( "clip",{ direction: "horizontal" }, 1000);
};     

