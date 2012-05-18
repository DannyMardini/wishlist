<?php $view->extend('::navBar.html.php') ?>

<html>
    <head>
        <link href="/css/help.css" rel="stylesheet" type="text/css" />
        <link href="/css/navBar.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/js/QABundle.js"></script>
    </head>
    <body>
        <form id="accountSettingsForm" method="POST" action="/app_dev.php/Notify/Admin">

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

        <input type="submit" value="Send" /> 
        </form>
    </body>
</html>

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
            //alert('input value is '+input.value);
        if (input.value != document.getElementById('new_password1').value) {
            //alert('input value is '+input.value);
            input.setCustomValidity('The two passwords must match.');
        } 
        else {
            // input is valid -- reset the error message
            input.setCustomValidity('');
        }
    }    

    $(document).ready(function(){
        $("#contactSupportForm").submit(function(e){
            e.preventDefault();
            var url = $(this).attr('action');
            var encoded_message = escape($("#message").val());

            $.post( url, {subject: $('#subject').val() , fullname: $("#full_name").val(), email: $("#email_addr").val(), message: encoded_message}, function(response){            

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
    });
    
    
    function redirectToQAHome()
    {
        window.location = "/app_dev.php/help";
    }
    
    
</script>