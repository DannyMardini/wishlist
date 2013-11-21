$(document).ready(function(){
    $('#reset-password').show();
    
    $('#close-window').click(closeView);
    
    $("#submit-new-password").submit(function(e){
        e.preventDefault();
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

function closeView()
{
    window.close();
}
