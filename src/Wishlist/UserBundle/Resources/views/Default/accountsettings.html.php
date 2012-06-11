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
        <input type="hidden" id="gender" value="<?php echo $gender ?>" />
        <form id="accountSettingsForm" action="/app_dev.php/SaveAccountSettings">

        <label>First Name:</label>
        <input type="text" id="full_name" name="first_name" placeholder="Jane" required value="<?php echo $firstName ?>">
        
        <label>Last Name:</label>
        <input type="text" id="full_name" name="last_name" placeholder="Doe" required value="<?php echo $lastName ?>">        

        <label>Email:</label>
        <input type="email" id="email_addr" name="email_addr" placeholder="email" value="<?php echo $email ?>">       
        <input type="email" id="email_addr_repeat" name="email_addr_repeat" placeholder="repeat email" oninput="checkEmail(this)">
        
        <label>Gender:</label>
        <div style="display:block;margin:0;padding:0;margin-bottom:15px;">
        <ul style="-webkit-padding-start: 5px;display:block;">
        <li style="list-style:none;display:inline;width:auto;clear:none;padding:4px 0 0 0;margin-right:34px;float:left;"><label style="float:right;display:block;width:auto;"><input style="width:15px;float:left; display:inline-block" type="radio" id="gender_1" name="Gender" value="1" />Male</label></li>
        <li style="list-style:none;display:inline;width:auto;clear:none;padding:4px 0 0 0;margin-right:34px;float:left;"><label style="float:right;display:block;width:auto;"><input style="width:15px;float:left; display:inline-block" type="radio" id="gender_2" name="Gender" value="2" />Female</label></li>
        <li style="list-style:none;display:inline;width:auto;clear:none;padding:4px 0 0 0;margin-right:34px;float:left;"><label style="float:right;display:block;width:auto;"><input style="width:15px;float:left; display:inline-block" type="radio" id="gender_0" name="Gender" value="0" />Unspecified</label></li>
        </ul>
        </div>        
        
        <label>Password:</label>
        <?php if(isset($originalPassword)) { ?>
        <input type="password" id="old_password" name="old_password" placeholder="old password">
        <?php } ?>
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