<?php $view->extend('::navBar.html.php') ?>

<html>
    <head>
        <link href="/css/lifeEventsManager.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/js/lifeEventsManager.js"></script>
    </head>
    <body>
        <div class="eventsHeader">
            <label>Life Events</label>
            <button title="add new life event" id="addLifeEventButton"></button>
            <button title="remove selected life events" id="removeLifeEventButton"></button>
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
                        <div class="checkbox"><input type="checkbox"></div>
                        <div class="image" title="<?php echo $eventName ?>"><img src="<?php echo $eventImage ?>" height="30" width="30" /></div>
                        <div class="name" title ="<?php echo $eventName ?>"><?php echo $name ?></div>
                        <div class="message" title="<?php echo $eventName ?>"><?php echo $timestamp ?></div>
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
        
<!--        <div class="lifeEventDiv right_content">
            <div class="right_innercontent">
                <div id="new_life_event_div" class="newEventDiv">                    
                    <label>Add New Event: </label>
                    <div class="flexbox">
                        <input type="text" id="newEventname" class="eventname" name="event_name" placeholder="name">
                        <input type="text" id="newDatepicker" class="datepicker" placeholder="mm/dd/yyyy">
                        <select id="newEventType">
                        <option value="-1">--Type--</option>
                        <option value="1">Birthday</option>
                        <option value="2">Anniversary</option>                
                        </select>
                        <img class="buttonClass" id="addEventButton" src="/images/plus_icon.jpeg" alt="Add a new life event" />
                    </div>                    
                </div>

                <div id="saved_life_events_div" class="newEventDiv" style="margin-top:20px">
                    <label> My Events: </label>                    
                </div>
            </div>
        </div>-->
        
    </body>
</html>
