$(document).ready(function(){
    $('#reset-password').show();
    
    $('#close-window').click(closeView);
    
    $("#submit-new-password").submit(function(e){
        e.preventDefault();
        
        if(!passwordValidation())
        {
            alert('The passwords do not match. Please re-type them and try again.');
            return;
        }        
        
        var urlVars = getUrlVars();
        var url = $(this).attr('action') + '?token=' + urlVars['token'] + '&email=' + urlVars['email'];

        $.post( url, {new_password1: $("#new_password1").val(),
            new_password2: $("#new_password2").val()},
            function(response){
            $('#reset-password').hide();
            var dataArray = response.split(":"); 
            var message = dataArray[1];
            $('#message').html(message);
        });
    });       
    
    $("#reset-password").submit(function(e){
        e.preventDefault();
        var url = $(this).attr('action');            

        $.post( url, {email: $("#email").val()}, function(response){            
            $('#reset-password').hide();
            var dataArray = response.split(":"); 
            var message = dataArray[1];
            $('#message').html(message);
        });
    });        
});

function passwordValidation()
{
    return $("#new_password1").val() === $("#new_password2").val();
}

function closeView()
{
    window.close();
}
