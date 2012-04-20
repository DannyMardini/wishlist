<link href="/css/QAMenu.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/js/jquery-1.7.1.js"></script>
<!--<script type="text/javascript" src="/js/QABundle.js"></script>-->
<input type="hidden" id="selectedOptionIndex" value="<?php echo $selectedOptionIndex; ?>" />
<div>
    <ul>
        <li class="topic">Basics</li>
        <li class="subTopic topic1" id="<?php echo $view['router']->generate('WishlistQABundle_gettingStarted')?>">Getting Started</li>
        <li class="subTopic topic2" id="<?php //echo $view['router']->generate('WishlistQABundle_friendsHelp')?>">Friends</li>
        <li class="subTopic topic3" id="<?php echo $view['router']->generate('WishlistQABundle_wishlistHelp')?>">Wishlist</li>
        <li class="subTopic topic4" id="<?php //echo $view['router']->generate('WishlistQABundle_shoppingHelp')?>">Shopping list</li>
        <li class="subTopic topic5" id="<?php //echo $view['router']->generate('WishlistQABundle_eventsHelp')?>">Events</li> 
        <li class="topic">Report Issues        
        </li>
    </ul> 
</div>
