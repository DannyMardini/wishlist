<?php
if(isset($gender))
    echo '<input type="hidden" id="orig_gender" value="'.$gender.'" />';

if(isset($name))
    echo '<input type="hidden" id="orig_name" value="'.$name.'" />';
    
if(isset($email))
    echo '<input type="hidden" id="orig_email" value="'.$email.'" />';
?>

<div>
<form id="accountSettingsForm" action="/app_dev.php/SaveAccountSettings">
<ul id='mainList'>
<li><label class='mainLabel'>Name:</label><input type="text" class="trackChanges" id="fullname" name="name" required></li>
<li><label class='mainLabel'>Email:</label><input type="email" class="trackChanges" id="email" name="email" placeholder="email" required></li>
<li><label class='mainLabel'>Gender:</label>
<ul id='genderPicker'>
    <li><input type="radio" id="gender_1" name="Gender" value="1" /><label>Male</label></li>
    <li><input type="radio" id="gender_2" name="Gender" value="2" /><label>Female</label></li>
    <li><input type="radio" id="gender_0" name="Gender" value="0" /><label>Unspecified</label></li>
</ul>
</li>

<li><label class='mainLabel'>Password:</label><ul id='passwordInputs'>
<?php if(isset($originalPassword)) { ?>
<input type="password" id="old_password" name="old_password" placeholder="old password">
<input type="password" class="trackChanges" id="new_password1" name="new_password1" placeholder="new password">
<input type="password" id="new_password2" name="new_password2" placeholder="repeat new password" oninput="checkPassword(this)">
<?php 
    }
    else
    {
?>
<li><input type="password" class="trackChanges" id="new_password1" name="new_password1" placeholder="new password" required></li>
<li><input type="password" id="new_password2" name="new_password2" placeholder="repeat new password" oninput="checkPassword(this)" required></li>
<?php } ?>
</ul>
</li>
</ul>
</form>
<form id="imageform" method="post" enctype="multipart/form-data" action='/app_dev.php/UploadUserImage'>
    <label class='mainLabel'>Upload image:</label>
    <span>
        <input type="file" name="photoimg" id="photoimg" />
        <?php if(isset($profileImage)) echo '<div id="preview">'.$profileImage.'</div>'; ?>
    </span>
</form>
</div>
<button id="saveChanges">Create</button>

<!--
<label class='leftColumn'>Email:</label><input type="text" class="trackChanges rightColumn" id="fullname" name="name" required>
<label class='leftColumn'>Gender:</label>
<ul class='rightColumn'>
    <li><label><input type="radio" id="gender_1" name="Gender" value="1" />Male</label></li>
    <li><label><input type="radio" id="gender_2" name="Gender" value="2" />Female</label></li>
    <li><label><input type="radio" id="gender_0" name="Gender" value="0" />Unspecified</label></li>
</ul>
<!--
<label>Name:</label>
<div class="right_content">
<input type="text" class="trackChanges" id="fullname" name="name" required>
</div>

<label>Email:</label>
<div class="right_content">
<input type="email" class="trackChanges" id="email" name="email" placeholder="email" required>        
</div>

<label>Gender:</label>
<div class="genderDiv right_content">
<ul>
<li><label><input type="radio" id="gender_1" name="Gender" value="1" />Male</label></li>
<li><label><input type="radio" id="gender_2" name="Gender" value="2" />Female</label></li>
<li><label><input type="radio" id="gender_0" name="Gender" value="0" />Unspecified</label></li>
</ul>
</div>

<label>Password:</label>
<div class="right_content">
<?php if(isset($originalPassword)) { ?>
<input type="password" id="old_password" name="old_password" placeholder="old password">
<?php } ?>
<input type="password" class="trackChanges" id="new_password1" name="new_password1" placeholder="new password">      
<input type="password" id="new_password2" name="new_password2" placeholder="repeat new password" oninput="checkPassword(this)">
</div>
</form>

<form id="imageform" method="post" enctype="multipart/form-data" action='/app_dev.php/UploadUserImage'>
    <label>Upload image</label>
    <div class="right_content">
    <input type="file" name="photoimg" id="photoimg" />
    <?php if(isset($profileImage)) echo '<div id="preview">'.$profileImage.'</div>'; ?>
    </div>
</form>

<button id="saveChanges">Create</button>
-->
</form>
<script type="text/javascript" src="/js/QABundle.js"></script>
<script type="text/javascript" src="/js/jquery.form.js"></script>
<script type="text/javascript" src="/js/accountsettings.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
