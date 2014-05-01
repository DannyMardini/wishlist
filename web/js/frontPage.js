function displayMessage(message, title)
{
    $('#myModalLabel').text(title);
    $('.modal-body').html(message);        
}

function redirectToHomePage()
{
    // redirect to the logged in users' home page
    window.location = $('#homepageLinkPath').val();
}

$(document).ready(function()
{ 
    $.ajaxSetup ({
        cache: false
    });   
      
    $('#loader').hide();         
          
    $("#loginForm").ajaxError(function(){
        displayMessage('We apologize, a system issue occurred!','Alert');        
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
                $('#myModal').modal('show');
                displayMessage(data, "Alert");            
            }
        }, null);
    });

    $('#requestInviteForm').submit(function(e) {
        e.preventDefault();
        var url = Routing.generate('RequestInvite');
        var info = {email: $("#email_addr").val()};
        $('#loader').show();
        ajaxPost(info, url, function(data){
            $('#loader').hide();
            $('#myModal').modal('show');
            displayMessage(data, "Alert");             
        }, null);
    });                      
    
    $(".about-link").click(function(){
        displayMessage(aboutMessage,'About Wishenda');
    });
//    // a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
//    $( "#dialog:ui-dialog" ).dialog( "destroy" );    
});

var aboutMessage = "The goal of Wishenda is to help everyone shop during holidays, birthdays, and \n\
                    any other special occasion. <br /><br /> \n\
                    <em>\"Every Christmas, we would type up our wish lists on a google spreadsheet and share it with our family. \n\
                    This gave us the idea to make Wishenda! We hope other people will find this tool as useful as we have.\"</em><br /><br />\n\
                    With Wishenda you know what all of your friends want and they know what you want. Shopping for each other will never be the same!";