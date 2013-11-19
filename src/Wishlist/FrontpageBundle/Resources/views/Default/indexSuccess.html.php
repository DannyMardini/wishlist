<html>
    <head>
        <link rel="shortcut icon" href="/images/favicon.ico">

        <script type="text/javascript" src="/js/jquery-1.8.2.js"></script>
        <script type="text/javascript" src="/js/jquery-ui-1.8.23.custom.min.js"></script>
        <link href="/css/black-tie/jquery-ui-1.8.23.custom.css" rel="stylesheet" />

        <link href="<?php echo $view['assets']->getUrl('compass/stylesheets/main.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
        <script src="<?php echo $view['assets']->getUrl('bundles/fosjsrouting/js/router.js') ?>" type="text/javascript"></script>
        <script src="<?php echo $view['router']->generate('fos_js_routing_js', array("callback" => "fos.Router.setData")) ?>"></script>        
    </head>
    <body>
        <link href="<?php echo $view['assets']->getUrl('compass/stylesheets/frontPage.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/js/frontPage.js"></script>

        <input type="hidden" id="homepageLinkPath" value="<?php echo $view['router']->generate('WishlistUserBundle_homepage')?>" />
        <div id="imageContainer"></div>
        <div id="registrationContainer">
            <div id="logoContainer">
                <div id="name">Wishenda</div>
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
                        <form id="requestInviteForm">
                            <label class="label">EMAIL:</label>
                            <input type="email" id="email_addr" name="email_addr" autofocus="autofocus" placeholder="Email address" required />
                            <br />
                            <input type="submit" id="submitRequestInvite" name="submitRequestInvite" value="Request Invite" />
                        </form>
                    </div>
                    <div id="loginToggleWindow">
                        <br /><br />
                        <form id="loginForm" method="POST" action="<?php echo $view['router']->generate('Validate') ?>">
                            <label class="label">EMAIL:</label>
                            <input type="email" id="login_email_addr" name="email_addr" autofocus="autofocus" placeholder="Email address or username" required />
                            <br />
                            <label class="label">PASSWORD:</label>
                            <input type="password" id="password" name="password" autocomplete="off" pattern="[A-Za-z0-9]{4,20}" required />
                            <br />
                            <input type="submit" id="submitLogin" name="submitLogin" value="Login" />
                            <a href="" id="forgotPassword" target="_blank" class="forgotPassword">Forgot your password?</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <div id="footerDetails">
                <a class="aboutLink frontpageLink" href="#">ABOUT</a>
                <img src="/images/silverdot.gif" width="10" height="10" />
                <a class="termsLink frontpageLink" href="#">TERMS</a>
                <img src="/images/silverdot.gif" width="10" height="10" />
                <a class="privacyLink frontpageLink" href="#">PRIVACY</a>
                <img src="/images/silverdot.gif" width="10" height="10" />
                <a class="joinLink frontpageLink" href="#">JOIN OUR TEAM</a>
            </div>
        </footer>
        <div id="dialog-message" title=""></div>
    </body>
</html>
