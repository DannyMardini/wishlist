function saveChanges()
{
    if(allFormsValid()) {
        sendFormValues();
    }
}

function displayInputError(currentInput, errorStr) {
    var errorDisplay = $('#errorDisplay');

    errorDisplay.html(errorStr);  //Is this the correct function?
    errorDisplay.show(); //Is this the correct function?
}

function allFormsValid()
{
    try {
        var currInput = $('#fullname');
        //Check name to see if it's empty or it's missing a last name.
        if (currInput.val().length <= 0) {
            throw 'Please enter a name.';
        }
        else if (currInput.val().split(' ').length < 2) {
            throw 'Please enter a first and last name.';
        }

        currInput = $('#email');
        //Check Email to see if it's empty or it contains an @ symbol.
        if (currInput.val().length <= 0) {
            throw 'Please enter an email';
        }
        else if (currInput.val().indexOf('@') == -1) {
            throw 'Please enter a valid email.';
        }

        currInput = $('input:checked');
        //Check Gender to see if at least one is picked.
        if (currInput.length <= 0) {
            currInput = $('#gender_1');
            throw 'Please choose a gender.';
        }

        currInput = $('#new_password1');
        //Check Password1 and Password2 to ensure they are both not empty and they are both the same.
        if (currInput.val().length <= 0) {
            throw 'Please enter a password.';
        }
        else if (currInput.val() != $('#new_password2').val())
        {
            throw 'Passwords do not match.';
        }
    }
    catch(e) {
        displayInputError(currInput, e);
        return false;
    }

    return true;
}

function sendFormValues()
{
    var url = $('#accountSettingsForm').attr('action');
    var genderVal = $('input:checked').val();
    
    $.post( url, {fullname: $('#fullname').val() , email: $("#email").val(), new_password: $('#new_password1').val(), 
                    gender: genderVal},
        function(response){
            $dataArray = response.split(":"); 
            if($dataArray[0].toLowerCase() == "success")
            {
                alert('Message sent.');
            }
            else
            {
                alert(response);
            }
    });
}

$(document).ready(function(){

    $('#saveChanges').click(saveChanges);
    
    $('#photoimg').live('change', function()	
    { 
        $("#preview").html('');
        $("#preview").html('<img src="/images/loader.gif" alt="Uploading...."/>');

        $("#imageform").ajaxForm(
        {
            target: '#preview'
        }).submit();    
    });     

    var gender = $('#orig_gender').val();
    $('#gender_'+gender).attr('checked',true);
    $('#fullname').val($('#orig_name').val());
    $('#email').val($('#orig_email').val());
});
