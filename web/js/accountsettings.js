    function checkEmail(input) {
        if (input.value != document.getElementById('email_addr').value) {
            input.setCustomValidity('The two email addresses must match.');
        } 
        else {
            // input is valid -- reset the error message
            input.setCustomValidity('');
        }
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

    $(document).ready(function(){
        
        $('#saveChanges').click(function(){
            
            var url = $('#accountSettingsForm').attr('action');
            
            $.post( url, {fullname: $('#full_name').val() , email: $("#email_addr").val(), 
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
        
    });
    
    
    function redirectToUserPage()
    {
        window.location = "/app_dev.php/Homepage/";
    }


