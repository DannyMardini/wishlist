<?php foreach ($view['assetic']->stylesheets(array('compass/stylesheets/QAMenu.css'), array('?yui_css')) as $url): ?>
<link rel="stylesheet" type="text/css" media="screen, projection" href="<?php echo $view->escape($url)."?rand=".rand() ?>" /><?php endforeach; ?>

<input type="hidden" id="selectedOptionIndex" value="<?php echo $selectedOptionIndex; ?>" />
<div>
    <ul>
        <li class="topic">Basics</li>
        <li class="subTopic topic1" id="<?php echo $view['router']->generate('WishlistQABundle_gettingStarted')?>">Getting Started</li>       
        <li class="subTopic topic3" id="<?php echo $view['router']->generate('WishlistQABundle_wishlistHelp')?>">Wish list</li>
        <li class="subTopic topic3" id="<?php echo $view['router']->generate('WishlistQABundle_shoppinglistHelp')?>">Shopping list</li>
        <li class="subTopic topic3" id="<?php echo $view['router']->generate('WishlistQABundle_eventsHelp')?>">Events</li>
        <li class="subTopic topic3" id="<?php echo $view['router']->generate('WishlistQABundle_friendsHelp')?>">Friends</li>
        <li class="subTopic topic3" id="<?php echo $view['router']->generate('WishlistQABundle_updatesHelp')?>">Updates</li>        
        <li class="topic">Report Issues
        <li class="subTopic topic4" id="<?php echo $view['router']->generate('WishlistQABundle_contactSupport')?>">Contact Support</li>
        </li>
    </ul> 
</div>
