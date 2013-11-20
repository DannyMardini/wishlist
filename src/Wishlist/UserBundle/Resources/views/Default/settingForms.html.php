<?php
if(isset($gender))
    echo '<input type="hidden" id="orig_gender" value="'.$gender.'" />';

if(isset($name))
    echo '<input type="hidden" id="orig_name" value="'.$name.'" />';
    
if(isset($email))
    echo '<input type="hidden" id="orig_email" value="'.$email.'" />';

if(isset($birthdate))
    echo '<input type="hidden" id="orig_birthdate" value="'.$birthdate.'" />';
?>

<div id='mainDiv'>
<!-- How do we know if this request came from someone updating their settings or from someone making a new account? -->
<form id="accountSettingsForm" action="<?php echo $view['router']->generate('WishlistUserBundle_save_account_settings') ?>">
<ul id='mainList'>
<li><label class='mainLabel'>Name:</label><input type="text" class="trackChanges" id="fullname" name="name" required/></li>
<li><label class='mainLabel'>Email:</label><input type="email" class="trackChanges" id="email" name="email" placeholder="email" required /></li>
<li>
    <label class='mainLabel'>Birthdate:</label>
    <input id="birthMonth" class="trackChanges birthdate" name="birthdate" type="text" placeholder="mm" required /> /
    <input id="birthDay" class="trackChanges birthdate" name="birthdate" type="text" placeholder="dd" required /> /
    <input id="birthYear" class="trackChanges birthdate" name="birthdate" type="text" placeholder="yyyy" required />
</li>
<li><label class='mainLabel'>Gender:</label>
<ul id='genderPicker'>
    <li><input type="radio" id="gender_1" name="Gender" value="1" /><label>Male</label></li>
    <li><input type="radio" id="gender_2" name="Gender" value="2" /><label>Female</label></li>
</ul>
</li>

<li><label class='mainLabel'>Password:</label><ul id='passwordInputs'>
<?php if(isset($originalPassword)) { ?>
<input type="password" id="old_password" name="old_password" placeholder="old password">
<input type="password" class="trackChanges" id="new_password1" name="new_password" placeholder="new password" required />
<input type="password" id="new_password2" name="new_password2" placeholder="repeat new password" required />
<?php 
    }
    else
    {
?>
<li><input type="password" class="trackChanges" id="new_password1" name="new_password" placeholder="new password" required /></li>
<li><input type="password" id="new_password2" name="new_password2" placeholder="repeat new password" required /></li>
<?php } ?>
</ul>
</li>
</ul>
</form>
<?php if(isset($originalPassword)) { ?>
<form id="imageform" method="post" enctype="multipart/form-data" action='<?php echo $view['router']->generate('WishlistUserBundle_uploadUserImage'); ?>'>
    <label class='mainLabel'>Upload image:</label>
    <span>
        <input type="file" name="photoimg" id="photoimg" />
        <?php if(isset($profileImage)) echo '<div id="preview">'.$profileImage.'</div>'; ?>
    </span>
</form>
<?php } ?>
</div>
<button id="saveChanges">Create</button>
<p id="errorDisplay"></p>
</form>
