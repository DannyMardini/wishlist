<link href="<?php echo $view['assets']->getUrl('compass/stylesheets/QAMenu.css') ?>" media="screen, projection" rel="stylesheet" type="text/css" />
<input type="hidden" id="selectedOptionIndex" value="<?php echo $selectedOptionIndex; ?>" />
<div>
    <ul>
        <li class="topic">Basics</li>
        <li class="subTopic topic1" id="<?php echo $view['router']->generate('WishlistQABundle_gettingStarted')?>">Getting Started</li>       
        <li class="subTopic topic3" id="<?php echo $view['router']->generate('WishlistQABundle_wishlistHelp')?>">Wishlist</li>
        <li class="topic">Report Issues
        <li class="subTopic topic4" id="<?php echo $view['router']->generate('WishlistQABundle_contactSupport')?>">Contact Support</li>
        </li>
    </ul> 
</div>
