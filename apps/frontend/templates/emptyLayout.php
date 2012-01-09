<!DOCTYPE HTML>

  <html>
    <?php include_http_metas() ?>
    <?php include_metas() ?>

    <link href='http://fonts.googleapis.com/css?family=Satisfy' rel='stylesheet' />
    <link href='http://fonts.googleapis.com/css?family=Gruppo' rel='stylesheet' />
    <link href="/css/custom-theme/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
    <link rel="shortcut icon" href="/images/favicon.ico">
    <script src="/js/jquery-1.6.2.min.js"></script>
    <script src="/js/jquery-ui-1.8.16.custom.min.js"></script>
    <script src="/js/common.js"></script>

    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <head><title><?php include_slot("title", "Wishlist") ?></title></head>

    <body><?php echo $sf_content ?></body>
</html>
