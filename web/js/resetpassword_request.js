$(document).ready(function(){
    $('#message').html('');
    $('#close-window').hide();
    
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
        var data = {new_password1: $("#new_password1").val(), new_password2: $("#new_password2").val()};

        ajaxPost(data, url, displayMessage, $('#submit-new-password'));
    });       
    
    $("#reset-password").submit(function(e){
        e.preventDefault();
        var url = $(this).attr('action');            
        var data = {email: $("#email").val()};
        
        ajaxPost(data, url, displayMessage, $('#reset-password'));
    });        
});

function displayMessage(response, textStatus, jqXHR, formId)
{
    formId.hide();
    var dataArray = response.split(":"); 
    var message = dataArray[1];
    $('#message').html(message);
    $('#close-window').show();    
}

function passwordValidation()
{
    return $("#new_password1").val() === $("#new_password2").val();
}

function closeView()
{
    window.close();
}
