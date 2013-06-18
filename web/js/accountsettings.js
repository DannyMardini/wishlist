var changes = {};
changes.count = 0;
window.onbeforeunload = promptConfirmation;

    function pushChange(elementId, newValue)
    {
        var key = elementId.toString();
        var orig_value = $("#orig_"+key).val();
        
        // check if the new value equals the original value
        if(newValue == orig_value)
        {
            popChange(key);
            return;
        }
        
        if(!changes.hasOwnProperty(key))
        {
            changes.count++;
        }
        
        changes[key] = newValue;
    }
    
    function popChange(key)
    {
        delete changes[key];
        changes.count--;
    }
    
    function checkPassword(input) {
        if (input.value != document.getElementById('new_password1').value) {
            input.setCustomValidity('The two passwords must match.');
        } 
        else {
            // input is valid -- reset the error message
            input.setCustomValidity('');
        }
    }    
    
    function promptConfirmation()
    {
        if(changes.count > 0){
            return "You have unsaved changes";
        }
    }

    $(document).ready(function(){
        
        $('#saveChanges').click(function(){
            var url = $('#accountSettingsForm').attr('action');
            
            $.post( url, {fullname: $('#fullname').val() , email: $("#email_addr").val(), 
                old_password: $("#old_password").val(), new_password: $('#new_password1').val()},
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

                    redirectToQAHome();
            });
        });
        
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
        
        $( "#newDatepicker" ).datepicker({
                changeMonth: true,
                changeYear: true
        });
       
        // add change event handlers
        $('.trackChanges').keyup(onEditInputEvent);
        
        // Disable save button
        disableSaveButton();
    });
    
    function disableSaveButton()
    {
        $('#saveChanges').attr('disabled', 'true');
        $('#saveChanges').addClass('disabledButton');
    }
    
    function enableSaveButton()
    {
        $('#saveChanges').removeAttr('disabled').removeClass('disabledButton');
        $('#saveChanges').addClass('enabledButton');
    }
    
    function toggleSaveButton()
    {
        if(changes.count > 0)
        {
            enableSaveButton();
        }else
        {
            disableSaveButton();
        }
    }
    
    function onEditInputEvent()
    {
        pushChange($(this).attr('id'), $(this).val());
        toggleSaveButton();
    }
    
    function redirectToUserPage()
    {
        window.location = "/app_dev.php/Homepage/";
    }