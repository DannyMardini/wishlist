<html>
    <head>
        <?php foreach ($view['assetic']->javascripts(
              array('js/jquery-1.8.2.js','js/frontPage.js','js/common.js', 'js/bootstrap/bootstrap.js'), array('?yui_js')) as $url): ?>
              <script src="<?php echo $view->escape($url)."?rand=".rand() ?>"></script><?php endforeach; ?>
        
        <?php foreach ($view['assetic']->stylesheets(
            array('css/bootstrap/bootstrap.css', 'compass/stylesheets/frontPage.css'), array('?yui_css')) as $url): ?>
            <link rel="stylesheet" type="text/css" media="screen, projection" href="<?php echo $view->escape($url)."?rand=".rand() ?>" /><?php endforeach; ?>
          
        <link href="<?php echo $view['assets']->getUrl('/css/black-tie/jquery-ui-1.8.23.custom.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="/images/favicon.ico">        
        <script type="text/javascript" src="/js/jquery-ui-1.8.23.custom.min.js"></script>
        <script src="<?php echo $view['assets']->getUrl('bundles/fosjsrouting/js/router.js') ?>" type="text/javascript"></script>
        <script src="<?php echo $view['router']->generate('fos_js_routing_js', array("callback" => "fos.Router.setData")) ?>"></script>
        <link href="<?php echo $view['assets']->getUrl('compass/stylesheets/fonts.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <input type="hidden" id="homepageLinkPath" value="<?php echo $view['router']->generate('WishlistUserBundle_homepage')?>" />
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container-fluid">            
            <div class="navbar-header">              
              <div class="navbar-brand" id="name">Wishenda</div>
            </div>           
            <form id="loginForm" class="navbar-form navbar-right" role="form">
              <div class="form-group">
                <label for="login_email_addr" class="sr-only">EMAIL:</label>
                <input type="email" class="form-control" id="login_email_addr" name="email_addr" autofocus="autofocus" placeholder="Email" required />                      
              </div>
              <div class="form-group">
                <label for="password" class="sr-only">PASSWORD:</label>
                <input type="password" class="form-control" id="password" name="password" autocomplete="off" pattern="[A-Za-z0-9]{4,20}" placeholder="Password" required />                            
              </div>  
              <button type="submit" class="btn btn-default" id="submitLogin" name="submitLogin" value="Sign in">Sign in</button>
              <span class="help-block"><a href="<?php echo $view['router']->generate('WishlistQABundle_forgotpassword')?>" id="forgotPassword" target="_blank" class="forgotPassword">Forgot password?</a></span>
            </form>
          </div>
        </nav>
        <div id="wishenda-details-div" class="panel panel-default">
          <div class="panel-body">
            <h2>Shop for your friends in minutes</h2>            
                <p>Add items from any online store to your global wish list</p>
                <p>Look at your friends' wish lists to find what to get them</p>
                <p>Use the shopping list to remember what to get your friends</p>
                <p>Share your wish list with friends for showers, weddings, etc</p>
          </div>
        </div>
        <div id="requestinvite-div" class="panel panel-default">
          <div class="panel-body">
            <h2>Request an invite</h2>
                <form class="navbar-form" role="form" id="requestInviteForm">
                    <div class="form-group">
                        <label for="email_addr" class="sr-only">EMAIL:</label>
                        <input type="email" class="form-control" id="email_addr" name="email_addr" autofocus="autofocus" placeholder="Email" required />
<!--                        <img id="loader" src="/images/swirl_loader.gif">-->
                    </div>  
                    <button type="submit" id="submitRequestInvite" name="submitRequestInvite" value="Request Invite" class="btn btn-default">Submit</button>
                </form>
          </div>
        </div>       
        <nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
          <div class="container">
             <div id="footerDetails">
                <a class="aboutLink frontpageLink" data-toggle="modal" data-target="#myModal" href="">About</a>
                <a class="frontpageLink" target="_blank" href="<?php echo $view['router']->generate('WishlistCoreBundle_Terms') ?>">Terms</a>
                <a class="frontpageLink" target="_blank" href="<?php echo $view['router']->generate('WishlistCoreBundle_PrivacyPolicy') ?>">Privacy</a>
                <br />
                <span>© 2014 Wishenda</span>
            </div>
          </div>
        </nav>
        <div id="dialog-message" title=""></div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
              </div>
              <div class="modal-body"></div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>        
              </div>
            </div>
          </div>
        </div>
    </body>
<!--    <body>
        <input type="hidden" id="homepageLinkPath" value="<?php echo $view['router']->generate('WishlistUserBundle_homepage')?>" />
        <div id="imageContainer"></div>
        <div id="registrationContainer">
            <div id="logoContainer">
                <div id="name">Wishenda</div>
                <div id="catchphrase">
                    <div class="catchphrasecontent">
                        <b>shopping for friends just got easier... do it in minutes</b><br />
                        <div class="catchphrasecontent-small">
                            Create a registry from all your favorite stores in one place.<br />
                            See your friends' wish lists.<br />
                            Keep a shopping list of items you plan to buy.         
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <div id="registrationForm">
                <br /><br />
                <button href="" id="requestInviteButton">Request Invite</button>
                <button href="" id="loginButton">Login</button>
                <br />
                <div class="toggler">
                    <div id="requestInviteToggleWindow"> 
                        <br />
                        <form role="form" id="requestInviteForm">
                            <label for="email_addr" class="sr-only">EMAIL:</label>
                            <input type="email" class="form-control" id="email_addr" name="email_addr" autofocus="autofocus" placeholder="Email" required /><img id="loader" src="/images/swirl_loader.gif">
                            <br />
                            <br />
                            <input type="submit" id="submitRequestInvite" name="submitRequestInvite" value="Request Invite" />
                        </form>
                    </div>
                    <div id="loginToggleWindow">
                        <br />
                        <form id="loginForm">
                            <label for="login_email_addr" class="sr-only">EMAIL:</label>
                            <input type="email" class="form-control" id="login_email_addr" name="email_addr" autofocus="autofocus" placeholder="Email" required />
                            <br />
                            <label for="password" class="sr-only">PASSWORD:</label>
                            <input type="password" class="form-control" id="password" name="password" autocomplete="off" pattern="[A-Za-z0-9]{4,20}" placeholder="Password" required />
                            <br />
                            <input type="submit" id="submitLogin" name="submitLogin" value="Login" />
                            <span class="help-block"><a href="<?php echo $view['router']->generate('WishlistQABundle_forgotpassword')?>" id="forgotPassword" target="_blank" class="forgotPassword">Forgot your password?</a></span>                            
                        </form>
                    </div>
                </div>
            </div>
            <?php 
            if(preg_match('/(?i)msie [4-8]/',$_SERVER['HTTP_USER_AGENT']))
            {
                echo "<h3 style='color: FF8282;'>Please consider upgrading to a modern browser such as 
                    <a href='https://www.google.com/intl/en/chrome/browser/' target='none'>Chrome</a> or 
                    <a href='http://www.mozilla.org/en-US/firefox/new/' target='none'>Firefox</a></h3>\n";
            }
            ?>
        </div>
        <footer>
            <div id="footerDetails">
                <a class="aboutLink frontpageLink" href="">About</a>
                <a class="frontpageLink" target="_blank" href="<?php echo $view['router']->generate('WishlistCoreBundle_Terms') ?>">Terms</a>
                <a class="frontpageLink" target="_blank" href="<?php echo $view['router']->generate('WishlistCoreBundle_PrivacyPolicy') ?>">Privacy</a>
                <br />
                <span>© 2014 Wishenda</span>
            </div>
        </footer>
        <div id="dialog-message" title=""></div>
    </body>-->
</html>
