<?php
if(isset($gender))
    echo '<input type="hidden" id="orig_gender" value="'.$gender.'" />';

if(isset($name))
    echo '<input type="hidden" id="orig_name" value="'.$name.'" />';
    
if(isset($email))
    echo '<input type="hidden" id="orig_email" value="'.$email.'" />';
?>

<form id="accountSettingsForm" action="/app_dev.php/SaveAccountSettings">

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
<input type="password" id="new_password2" name="new_password2" placeholder="repeat new password"
oninput="checkPassword(this)">
</div>

</form>

<form id="imageform" method="post" enctype="multipart/form-data" action='/app_dev.php/UploadUserImage'>
    <label>Upload image</label>
    <div class="right_content">
    <input type="file" name="photoimg" id="photoimg" />
    <?php if(isset($profileImage)) echo '<div id="preview">'.$profileImage.'</div>'; ?>
    </div>
</form>


<input id="saveChanges" type="submit" value="Save Changes" class="inputField uiButtonConfirm uiButton" />

