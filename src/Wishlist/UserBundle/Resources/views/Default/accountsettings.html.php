<?php $view->extend('::navBar.html.php') ?>

<html>
    <head>
        <link href="/css/formStyling.css" rel="stylesheet" type="text/css" />
        <link href="/css/accountsettings.css" rel="stylesheet" type="text/css" />
        <link href="/css/navBar.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/js/QABundle.js"></script>
        <script type="text/javascript" src="/js/jquery.form.js"></script>
        <script type="text/javascript" src="/js/accountsettings.js"></script>
    </head>
    <body>
        <form id="accountSettingsForm" action="/app_dev.php/SaveAccountSettings">

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