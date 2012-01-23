<!DOCTYPE HTML>

  <html>
    <?php include_http_metas() ?>
    <?php include_metas() ?>

    <link href='http://fonts.googleapis.com/css?family=Satisfy' rel='stylesheet' />
    <link href='http://fonts.googleapis.com/css?family=Gruppo' rel='stylesheet' />
    <link href="/css/custom-theme/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
    <link rel="shortcut icon" href="/images/favicon.ico">
    <script src="/js/jquery-1.7.1.js"></script>
    <script src="/js/jquery-ui-1.8.16.custom.min.js"></script>
    <script src="/js/common.js"></script>
    
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <head><title><?php include_slot("title", "Wishlist") ?></title></head>
    
    <body>
      <?php
      $email = $_SESSION['user'];
      $user = WishlistUserTable::getInstance()->getUserWithEmail($email);
      ?>
      
      <?php include_component('navBar', 'showNavBar', array( 'username' => $user->getFirstName(), 'user_id' => $user->getWishlistuserId())); ?>
      <div id="content" class="clearfix">
      <?php echo $sf_content ?>
      </div>
    </body>
</html>
