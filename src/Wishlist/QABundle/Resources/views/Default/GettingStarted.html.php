<html>
    <head>
        <link href="/css/help.css" rel="stylesheet" type="text/css" />
            <link href="/css/navBar.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <?php $view->extend('::navBar.html.php') ?>
        <header>How can we help you?</header>
        <div class="content">
            <div class="contentMenu">                
                <?php echo $view->render('WishlistQABundle:Default:QAMenu.html.php'); ?>
            </div>
            <div class="contentInfo">
                <div class="contentInfoTopic">What is Wishlist?</div>
                <div class="contentInfoDetails">
                    Wishlist lets you keep track of all of your wishes in one location and shares your list with friends! <br />
                    Your friends can see when your birthday or anniversary is coming up and get you a present from your list without you knowing!<br /><br />
                    Our Goal is to make life easier by providing a central location where everyone can bookmark their wishes and their friends can easily see what they want!<br /><br />                    
                </div>
                <div class="contentInfoTopic">Adding Wishes</div>
                <div class="contentInfoDetails">
                    To add a wish, blah blah blah
                </div>                
                <div class="contentInfoTopic">Account Settings</div>
                <div class="contentInfoTopic">Linking to your website</div>                
            </div>
        </div>
        <footer>end</footer>
    </body>    
</html>