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
        <input type="submit" id="requestInviteButton" value="Request Invite">
        <input type="submit" id="loginButton" value="Login">
        <input type="text" name="date" id="date" />
        <br />
        <div class="toggler">
            <div id="effect" class="ui-widget-content ui-corner-all">
                <h3 class="ui-widget-header ui-corner-all">Show</h3>
                <p>
                        Etiam libero neque, luctus a, eleifend nec, semper at, lorem. Sed pede. Nulla lorem metus, adipiscing ut, luctus sed, hendrerit vitae, mi.
                </p>
            </div>
        </div>
    </div>
</div>
<footer>the footer</footer>
