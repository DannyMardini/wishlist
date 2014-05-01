<!DOCTYPE html>
<html>
    <head>        
        <?php foreach ($view['assetic']->javascripts(array('js/jquery-1.8.2.js', 'js/resetpassword_request.js', 'js/common.js', 'js/bootstrap/bootstrap.js'), array('?yui_js')) as $url): ?>
        <script src="<?php echo $view->escape($url)."?rand=".rand() ?>"></script><?php endforeach; ?>        
        <?php foreach ($view['assetic']->stylesheets(array('css/bootstrap/bootstrap.css', 'compass/stylesheets/resetpassword.css'), array('?yui_css')) as $url): ?>
        <link rel="stylesheet" type="text/css" media="screen, projection" href="<?php echo $view->escape($url)."?rand=".rand() ?>" /><?php endforeach; ?>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="/images/favicon.ico">
        <title>Reset Password</title>
    </head>
    <body>
        <div class="toolbar">
            <button id="close-window" name="close-window" class="btn btn-default">Go Back</button>
        </div>
        <div class="panel-container">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form id="reset-password" class="reset-password" method="POST" action="<?php echo $view['router']->generate('WishlistQABundle__resetpasswordrequest') ?>">
                        <div class="form-group">
                            <h3>Enter your email and we will send you instructions.</h3>
                            <label class="form-input-label" class="sr-only" for="email_addr"></label>
                            <input type="email" class="form-control" id="email" name="email" autofocus="autofocus" placeholder="Email" required />
                        </div>
                        <button type="submit" id="submitPasswordResetRequest" name="submitPasswordResetRequest" value="Submit" class="btn btn-default">Submit</button>
                    </form>
                </div>                
            </div>
        </div>        
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">                  
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
              </div>
              <div class="modal-body">
                <article id="message"></article>                    
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>        
              </div>
            </div>
          </div>
        </div>        
    </body>
</html>
