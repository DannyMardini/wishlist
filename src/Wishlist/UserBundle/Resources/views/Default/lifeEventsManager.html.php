<?php $view->extend('::navBar.html.php') ?>

<html>
    <head>
        <link href="/css/lifeEventsManager.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/js/lifeEventsManager.js"></script>
    </head>
    <body>
        <div class="eventsHeader">
            <label>Life Events</label>
            <button title="add event" id="addLifeEventButton"></button>
            <button title="remove event(s)" id="removeLifeEventButton"></button>
            <button title="save changes" id="saveLifeEventButton"></button>
        </div>
        <hr size="1" width="90%" color="grey">
        <div id="EventList" class="eventListDiv">
            <?php  
            if(count($events) > 0)
            {
                foreach ($events as $event) {
                        $eventImage = $event->getEventImage();
                        $eventName = $event->getName();
                        $friend = $event->getWishlistUser();
                        $eventDate = $event->getFormattedTimestamp();
                        $name = "<a href='User/".$friend->getWishlistUserId()."/' >".$friend->getFirstname()." ".$friend->getLastname()."</a>";
                        $timestamp = " -- ".$eventDate;
           ?>  
                    <div class="Event"> 
                        <div class="checkbox"><input name="selected" type="checkbox"></div>
                        <div class="image" title="<?php echo $eventName ?>"><img src="<?php echo $eventImage ?>" height="30" width="30" /></div>
                        <div class="name" title ="<?php echo $eventName ?>"><?php echo $eventName ?></div>
                        <div class="timestamp" title="<?php echo $eventName ?>"><?php echo $timestamp ?></div>
                    </div>
           <?php 

                } 
            }
            else 
            { 
               echo "You haven't added any life events yet.";
            }
           ?>            
        </div>
    </body>
</html>
