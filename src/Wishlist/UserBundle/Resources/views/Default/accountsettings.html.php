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
        
        <label>Gender:</label>
        <div class="genderDiv">
        <ul>
        <li><label><input type="radio" id="gender_1" name="Gender" value="1" />Male</label></li>
        <li><label><input type="radio" id="gender_2" name="Gender" value="2" />Female</label></li>
        <li><label><input type="radio" id="gender_0" name="Gender" value="0" />Unspecified</label></li>
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