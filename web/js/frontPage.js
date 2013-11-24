
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
                displayMessage(data);            
            }
        }, null);
    });

    $('#requestInviteForm').submit(function(e) {
        e.preventDefault();
        var url = Routing.generate('RequestInvite');
        var info = {email: $("#email_addr").val()};
        ajaxPost(info, url, function(data){
            displayMessage(data);             
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
    
    
    $(".aboutLink").click(function(){eval('displayMessageDialog(aboutMessage, "What is Wishlist?")')});
    $(".termsLink").click(function(){eval('displayMessageDialog(termsMessage, "Terms and Conditions?")')});
    
    // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
    $( "#dialog:ui-dialog" ).dialog( "destroy" );

    
});

var aboutMessage = "Our Goal is to make your life easier by never having to worry about giving \n\
    or receiving a bad gift again. View your friends and families wishlists and even share your own.<br /><br /> \n\
    Gift giving has never been simpler!";

var termsMessage = "<b><u>Terms:</u></b><i> TO DO";

function displayMessageDialog(msg, title)
{    
    $( "#dialog-message" ).attr('title',title);    
    displayMessage(msg);
}

function displayMessage(message)
{
    $('#dialog-message').html(message);
    $( "#dialog-message" ).dialog({
        title: 'Alert',
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
