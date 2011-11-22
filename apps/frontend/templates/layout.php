<!DOCTYPE HTML>

  <html>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
   
    <!-- <link rel="shortcut icon" href="/favicon.ico" /> -->

    <link href='http://fonts.googleapis.com/css?family=Satisfy' rel='stylesheet' type='text/css'/>
    <link href='http://fonts.googleapis.com/css?family=Gruppo' rel='stylesheet' type='text/css'/>
    <link type="text/css" href="css/custom-theme/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
    <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
    
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <head><title><?php include_slot("title", "Wishlist") ?></title></head>
    
    <body><?php echo $sf_content ?></body>
</html>
