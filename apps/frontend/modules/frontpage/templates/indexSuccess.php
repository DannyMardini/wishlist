<?php use_stylesheet('frontPage.css') ?>
<?php use_javascript('frontPage.js') ?>

<div id="signInContainer">
    <a id="aboutLink" href="#">About</a>
    <img src="/images/silverdot.gif" width="10" height="10" />
    <a id="signInLink" href="#">Login</a>
</div>
<div id="imageContainer"></div>
<div id="registrationContainer">
    <div id="logoContainer">
        <div id="name">Wishlist</div>
        <div id="catchphrase">make your wishes come true!</div>
    </div>
    <div id="registrationForm">
        <a href="#" id="requestInviteButton" class="ui-state-default ui-corner-all">Request Invite</a>        
        <a href="#" id="loginButton" class="ui-state-default ui-corner-all">Login</a>
        <br />
        <div class="toggler">
            <div id="requestInviteToggleWindow" class="ui-widget-content ui-corner-all">
                <h3 class="ui-widget-header ui-corner-all">Submit Request Invite</h3>
                
            </div>
            <div id="loginToggleWindow" class="ui-widget-content ui-corner-all">
                <h3 class="ui-widget-header ui-corner-all">Enter Login Info</h3>
                <p>
                       Please enter your login information.
                </p>
            </div>
        </div>
    </div>
</div>
<footer>the footer</footer>
