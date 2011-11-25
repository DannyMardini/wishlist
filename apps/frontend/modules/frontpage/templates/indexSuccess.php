<?php use_stylesheet('frontPage.css') ?>
<?php use_javascript('frontPage.js') ?>
<?php phpinfo() ?>
<div id="loginContainer">
    <a id="aboutLink" href="#">About</a>
    <img src="/images/silverdot.gif" width="10" height="10" />
    <a id="loginLink" href="#">Login</a>
</div>
<div id="imageContainer"></div>
<div id="registrationContainer">
    <div id="logoContainer">
        <div id="name">Wishlist</div>
        <div id="catchphrase">make your wishes come true!</div>
    </div>
    <div id="registrationForm">
        <br /><br />
        <a href="#" id="requestInviteButton">Request Invite</a>        
        <a href="#" id="loginButton">Login</a>
        <br />
        <div class="toggler">
            <div id="requestInviteToggleWindow"> 
                <br /><br />
                <form action="/frontpage" method="post">
                    <label class="label">EMAIL:</label>
                    <input type="email" id="email_addr" name="email_addr" autofocus="autofocus" placeholder="Email address" required />
                    <br />
                    <input type="submit" id="submitRequestInvite" name="submitRequestInvite" value="Request Invite" />
                </form>
            </div>
            <div id="loginToggleWindow">
                <br /><br />
                <form>
                    <label class="label">EMAIL or USERNAME:</label>
                    <input type="email" id="email_addr" name="email_addr" autofocus="autofocus" placeholder="Email address or username" required />
                    <br />
                    <label class="label">PASSWORD:</label>
                    <input type="password" id="password" name="password" autocomplete="off" pattern="[A-Za-z0-9]{4,20}" required />
                    <br />
                    <input type="submit" id="submitLogin" name="submitLogin" value="Login" />
                </form>
            </div>
        </div>
    </div>
</div>
<footer>
    <div id="footerDetails">
        <a id="aboutLink" href="#">ABOUT</a>                
        <img src="/images/silverdot.gif" width="10" height="10" />
        <a id="loginLink" href="#">CONTACT</a>
        <img src="/images/silverdot.gif" width="10" height="10" />
        <a id="loginLink" href="#">HELP</a>
        <img src="/images/silverdot.gif" width="10" height="10" />
        <a id="loginLink" href="#">TERMS</a>
        <img src="/images/silverdot.gif" width="10" height="10" />
        <a id="loginLink" href="#">PRIVACY</a>
        <img src="/images/silverdot.gif" width="10" height="10" />
        <a id="loginLink" href="#">JOIN OUR TEAM</a>
    </div>
</footer>
