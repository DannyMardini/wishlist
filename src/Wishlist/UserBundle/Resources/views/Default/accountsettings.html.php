<?php $view->extend('::navBar.html.php') ?>

<html>
    <head>
        <link href="/css/formStyling.css" rel="stylesheet" type="text/css" />
        <link href="/css/navBar.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/js/QABundle.js"></script>
        <script type="text/javascript" src="/js/jquery.form.js"></script>
    </head>
    <body>
        <form id="accountSettingsForm">

        <label>Full name:</label>
        <input type="text" id="full_name" name="full_name" placeholder="Jane Doe" required>

        <label>Email address:</label>
        <input type="email" id="email_addr" name="email_addr" placeholder="email">

        <input type="email" id="email_addr_repeat" name="email_addr_repeat" placeholder="repeat email"
        oninput="checkEmail(this)">
        
        <label>Password:</label>
        <input type="password" id="old_password" name="old_password" placeholder="old password">
        
        <input type="password" id="new_password1" name="new_password1" placeholder="new password">      
        <input type="password" id="new_password2" name="new_password2" placeholder="repeat new password"
        oninput="checkPassword(this)">
        
        </form>
        
        <form id="imageform" method="post" enctype="multipart/form-data" action='/app_dev.php/UploadUserImage'>
            Upload image <input type="file" name="photoimg" id="photoimg" />
            <div id='preview'></div>
        </form>
        
        
        <input id="saveChanges" type="submit" value="Save Changes" class="inputField" />
        
        
    </body>
</html>
<style>

body

form {
    margin-top: 0;
    padding-top: 5px;
}

.preview
{
width:200px;
border:solid 1px #dedede;
padding:10px;
}
#preview
{
color:#cc0000;
font-size:12px
}
.inputField 
{
  width:300px;
  margin: 20px auto;
}
</style>
<script>
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
            
            // TO BE CONTINUED HERE
            
            //var url = $(this).attr('action');
            //var encoded_message = escape($("#message").val());

//            $.post( url, {subject: $('#subject').val() , fullname: $("#full_name").val(), email: $("#email_addr").val(), message: encoded_message}, function(response){            
//
//                $dataArray = response.split(":"); 
//
//                if($dataArray[0].toLowerCase() == "success")
//                {
//                    alert('Message sent.');
//                }
//                else
//                {
//                    alert(response);
//                }
//                
//                redirectToQAHome();
//            });
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
    
    
</script>