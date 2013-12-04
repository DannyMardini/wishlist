
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
         
    $("#loginForm").ajaxSuccess(function(){
    });    
          
          
    $("#loginForm").ajaxComplete(function(){
    }); 
    
          
    $("#loginForm").ajaxError(function(){
        alert("Fail");
    }); 
    $("#loginForm").submit(function(e){
        // validate user via ajax call
        e.preventDefault();        
        var url = Routing.generate('Validate');
        var info = {email: $("#login_email_addr").val(), password: $("#password").val()};
        
        ajaxPost(info, url, function(data){
            $dataArray = data.split(","); 
            if($dataArray[0].toLowerCase() === "continue")
            {
                redirectToHomePage(); // redirect to home page
            }
            else
            {
                displayMessage(data, "Alert");            
            }
        }, null);
    });

    $('#requestInviteForm').submit(function(e) {
        e.preventDefault();
        var url = Routing.generate('RequestInvite');
        var info = {email: $("#email_addr").val()};
        ajaxPost(info, url, function(data){
            displayMessage(data, "Request Submitted");             
        }, null);
    });    
     
                 
    // set effect from log in or request invite buttons
    $("#requestInviteButton, #loginButton, #loginLink").click(function(e) {
        e.preventDefault();
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
    
    
    $(".aboutLink").click(function(e){
        e.preventDefault();
        eval('displayMessageDialog(aboutMessage, "What is Wishlist?")');
    });
    
    // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
    $( "#dialog:ui-dialog" ).dialog( "destroy" );

    
});

var aboutMessage = "The founders of Wishenda came up with the idea of making this site in hopes that it would help \n\
                    their friends and family out during holidays, birthdays, and any other special occasion. <br /><br /> \n\
                    Message from the founders:<br /> \n\
                    'Every year for christmas we would write up our wish lists and wanted an easy way to share it with our close friends and family so that they would know what we want. \n\
                    This gave us the idea to make this site and hope that other people would be able to use it to do the same.' <br /><br />\n\
                    With Wishenda you know what all of your friends want and they know what you want.<br /> \n\
                    Shopping for each other has never been easier!";

var termsMessage = "<b><u>Terms:</u></b><i> TO DO";

function displayMessageDialog(msg, title)
{  
    displayMessage(msg, title);
}

function displayMessage(message, title)
{
    $('#dialog-message').html(message);
    $( "#dialog-message" ).dialog({
        title: title,
        position: 'top',
        modal: true,
        height:400,
        width:400,
        buttons: {
                Ok: function() {
                        $( this ).dialog( "close" );
                }
        }
    }); 
}


function redirectToHomePage()
{
    // redirect to the logged in user's home page
    window.location = $('#homepageLinkPath').val();
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
    $('#requestInviteToggleWindow').hide();
    $('#loginToggleWindow').hide();        
}
