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
        <input type="hidden" id="orig_gender" value="<?php echo $gender ?>" />
        <input type="hidden" id="orig_firstName" value="<?php echo $firstName ?>" />
        <input type="hidden" id="orig_lastName" value="<?php echo $lastName ?>" />
        <input type="hidden" id="orig_email" value="<?php echo $email ?>" />
        
        <form id="accountSettingsForm" action="/app_dev.php/SaveAccountSettings">

        <label>First Name:</label>
        <div class="right_content">
        <input type="text" id="firstName" name="firstName" placeholder="Jane" required>
        </div>
        
        <label>Last Name:</label>
        <div class="right_content">
        <input type="text" id="lastName" name="lastName" placeholder="Doe" required>        
        </div>
        
        <label>Email:</label>
        <div class="right_content">
        <input type="email" id="email" name="email" placeholder="email" required>        
        </div>
        
        <label>Gender:</label>
        <div class="genderDiv right_content">
        <ul>
        <li><label><input type="radio" id="gender_1" name="Gender" value="1" />Male</label></li>
        <li><label><input type="radio" id="gender_2" name="Gender" value="2" />Female</label></li>
        <li><label><input type="radio" id="gender_0" name="Gender" value="0" />Unspecified</label></li>
        </ul>
        </div>
        
        <label>Life Events:</label>        
        <div class="right_content">            
            <div style="text-decoration: underline; margin-left: 150px;">
                <span style="display:block;"> New Event: </span>
                <input style="margin-right:5px;width:20%; float:left; display:inline-block" type="text" name="event_name" placeholder="name">
                <input style="margin-right:5px;width:20%;float:left;display:inline-block" type="text" id="datepicker" placeholder="mm/dd/yy">
                <select class="life_event_select" style="margin-right:5px;width:20%; float:left;display:inline-block">
                <option value="-1">--Type--</option>
                <option value="1">Birthday</option>
                <option value="2">Anniversary</option>                
                </select>
                <img class="buttonClass" src="/images/plus_icon.jpeg" alt="Add a new life event" />
            </div>
            <div style="text-decoration: underline; width:50%;margin-left: 150px; float:left;">
                <span style="display:block;"> View Saved Events: </span>
                <ul><li>Bippy Anniv</li></ul>
            </div>            
        </div>
        
        <label>Password:</label>
        <div class="right_content">
        <?php if(isset($originalPassword)) { ?>
        <input type="password" id="old_password" name="old_password" placeholder="old password">
        <?php } ?>
        <input type="password" id="new_password1" name="new_password1" placeholder="new password">      
        <input type="password" id="new_password2" name="new_password2" placeholder="repeat new password"
        oninput="checkPassword(this)">
        </div>
        
        </form>
        
        <form id="imageform" method="post" enctype="multipart/form-data" action='/app_dev.php/UploadUserImage'>
            <label>Upload image</label>
            <div class="right_content">
            <input type="file" name="photoimg" id="photoimg" />
            <div id='preview'><?php echo $profileImage ?></div>
            </div>
        </form>
        
        
        <input id="saveChanges" type="submit" value="Save Changes" class="inputField" />
        
        
    </body>
</html>