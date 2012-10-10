<?php $view->extend('::navBar.html.php') ?>

<html>
    <head>
        <link href="/css/lifeEventsManager.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/js/lifeEventsManager.js"></script>
        <script type="text/javascript" src="/js/common.js"></script>
    </head>
    <body>
        <div class="eventsHeader">
            <label>Events</label>
            <button title="add event" id="addLifeEventButton"></button>            
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
                        <button class="remove" title="remove event"></button>
                        <button class="edit" title="edit event"></button>
                        <div class="image" title="<?php echo $eventName ?>"><img src="<?php echo $eventImage ?>" height="30" width="30" /></div>
                        <div class="name" title ="<?php echo $eventName ?>"><?php echo $eventName ?></div>
                        <div class="timestamp" title="<?php echo $eventName ?>"><?php echo $timestamp ?></div>
                    </div>
           <?php 

                } 
            }
            else 
            { 
               echo "You haven't added any events yet.";
            }
           ?>            
        </div>
        <div style="display:none;" id="newEventPanel">
            <input id="newEventname" type="text" required placeholder="Name" />
            <input id="newDatepicker" type="date" required placeholder="Date" />
            <select id="newEventType"><option value="-1">Select Type</option>
                <option value="1">Birthday</option>
                <option value="2">Anniversary</option>
                <option value="0">Other</option></select>
            <input id="saveNewEvent" type="submit" value="Save">
        </div>
    </body>
</html>
