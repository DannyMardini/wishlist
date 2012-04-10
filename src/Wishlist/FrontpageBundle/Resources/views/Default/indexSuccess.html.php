<html>
    <head>
<!--        <link href='http://fonts.googleapis.com/css?family=Satisfy' rel='stylesheet' />
        <link href='http://fonts.googleapis.com/css?family=Gruppo' rel='stylesheet' />-->
        <link rel="shortcut icon" href="/images/favicon.ico">
        <script type="text/javascript" src="/js/jquery-1.7.1.js"></script>
        <script type="text/javascript" src="/js/jquery-ui-1.8.16.custom.min"></script>
        <link href="/css/custom-theme/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
        <link href="/css/main.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <link href="/css/frontPage.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/js/frontPage.js"></script>

        <input id="showUserAdded" type="hidden" value="<?php echo $showUserAdded ?>" />
        <div id="loginContainer">
            <a id="aboutLink" href="#">About</a>
            <img src="/images/silverdot.gif" width="10" height="10" />
            <a id="loginLink" href="#">Login</a>
        </div>
        <div id="imageContainer"></div>
        <div id="registrationContainer">
            <div id="logoContainer">
                <div id="name"><image src="/images/wishlist_logo_large.png"></div>
                <div id="catchphrase"><image src="/images/wishlist_catchphrase.png"></div>
<!--                <div id="catchphrase">make your wishes come true!</div>-->
            </div>
            <div id="registrationForm">
                <br /><br />
                <a href="#" id="requestInviteButton">Request Invite</a>
                <a href="#" id="loginButton">Login</a>
                <br />
                <div class="toggler">
                    <div id="requestInviteToggleWindow"> 
                        <br /><br />
                        <form id="requestInviteForm">
                            <label class="label">EMAIL:</label>
                            <input type="email" id="email_addr" name="email_addr" autofocus="autofocus" placeholder="Email address" required />
                            <br />
                            <input type="submit" id="submitRequestInvite" name="submitRequestInvite" value="Request Invite" />
                        </form>
                    </div>
                    <div id="loginToggleWindow">
                        <br /><br />
                        <form id="loginForm" method="POST" action="<?php echo $loginURL ?>">
                            <label class="label">EMAIL:</label>
                            <input type="email" id="login_email_addr" name="email_addr" autofocus="autofocus" placeholder="Email address or username" required />
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
        <div id="dialog-message" title=""></div>
    </body>
</html>
