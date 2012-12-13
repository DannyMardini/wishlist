
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
        //alert("Success");
    });    
          
          
    $("#loginForm").ajaxComplete(function(){
        //alert("Complete");
    }); 
    
          
    $("#loginForm").ajaxError(function(){
        alert("Fail");
    }); 
    $("#loginForm").submit(function(e){
        // validate user via ajax call
        e.preventDefault();
        var url = $(this).attr('action');
        
        $.post( url, {email: $("#login_email_addr").val(), password: $("#password").val()}, function(data){            
            
            $dataArray = data.split(","); 
            
            if($dataArray[0].toLowerCase() == "continue")
            {
                // redirect to home page
                redirectToHomePage();           
            }
            else
            {
                displayMessage($dataArray[0]);            
            }
        });
    });

    $('#requestInviteForm').submit(function(e) {
        e.preventDefault();
        
        $.post('/frontpage/requestInvite', {email: $("#email_addr").val()}, function(data){
            displayMessage(data);             
        });
    });    
     
                 
    // set effect from log in or request invite buttons
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
    
    
    $(".aboutLink").click(function(){eval('displayMessageDialog(aboutMessage, "What is Wishlist?")')});
    $(".termsLink").click(function(){eval('displayMessageDialog(termsMessage, "Terms and Conditions?")')});
    
    // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
    $( "#dialog:ui-dialog" ).dialog( "destroy" );

    
});

var aboutMessage = "<b><u>Our Goal:</u></b><i> to make your life easier by providing a \n\
    central location where you can easily bookmark and keep track of your wishes; making it \n\
    easy for your friends to see and get you just what you want!</i><br /><br />\n\
    Return to the previous page and request an invite to create your wishlist today!";

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
        modal: true,
        height:400,
        width:600,
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


   

