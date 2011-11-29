

function displayPendingRegistrantMessage()
{
    alert("An invite will be sent to you soon. Thank you. - Wishlist Team");
}

function displayComplete(event, XMLHttpRequest, ajaxOptions)
{
    alert("An AJAX request was made.");
}

function displaySuccess(data, textStatus, jqXHR)
{
    alert("Successfull ajax call.");
}

function displayError(jqXHR, textStatus, errorThrown)
{
    alert("error ajax call.");
}

// run the currently selected effect
function runEffect(togglerWindow) {        
        $(togglerWindow ).show( "slide",{direction: "left"}, 1500);
};  

$(document).ready(function()
{
    $.ajaxSetup ({
        cache: false
    });


    setupCSS();    
    
    // hide toggle windows
    hideToggleWindows();
    
    // hover effects
    $('#requestInviteButton, #loginButton, #submitRequestInvite, #submitLogin').hover(
        function() {$(this).addClass('ui-state-hover');}, 
        function() {$(this).removeClass('ui-state-hover');}
     ); 
    
    $("#submitLogin").click(function(){
        // validate user via ajax call
        
    });

    $('#requestInviteToggleWindow').ajaxComplete(function() {
        alert('AJAX completed!');
    });

    $('#submitRequestInvite').ajaxError(function() {
        alert('AJAX failed!');
    })

    $('#submitRequestInvite').submit(function() {
        return false;
    });

    $.post('/frontpage/requestInvite', {email: $("#email_addr").val()}, function(data){
        alert("Data received from server: " + data);
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


function displayPendingRegistrantMessage()
{
    alert("An invite will be sent to you soon. Thank you. - Wishlist Team");
}


function redirectToHomePage(userId)
{
    // redirect to the logged in user's home page
    window.location = "http://www.google.com";
}

// run the currently selected effect
function runEffect(togglerWindow) {        
    $(togglerWindow ).show( "slide",{direction: "left"}, 1500);
} 


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
   // $('#requestInviteToggleWindow').hide();
    $('#loginToggleWindow').hide();        
}


   

