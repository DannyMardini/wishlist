<?php $view->extend('::navBar.html.php') ?>

<html>
    <head>
        <link href="/css/lifeEventsManager.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/js/lifeEventsManager.js"></script>
        <script type="text/javascript" src="/js/common.js"></script>
    </head>
    <body>
        <div class="eventsHeader">
            <?php $eventCount = count($events); ?>
            <label class="pageHeader" id="event_count_<?php echo $eventCount ?>">Events ( <?php echo $eventCount ?> )</label>
            <button class="addButton" title="add event" id="addLifeEventButton"><span class="ui-icon ui-icon-plus wishenda-button"></span></button>
        </div>        
        <hr size="1" width="90%" color="grey">
        <div id="EventList" class="eventListDiv">
            <?php  
            if($eventCount > 0)
            {
                foreach ($events as $event) {
                        $eventId = $event->getId();
                        $eventImage = $event->getEventImage();
                        $eventName = $event->getName();
                        $eventDate = $event->getFormattedTimestamp();
                        $timestamp = " -- ".$eventDate;
           ?>  
                    <div class="Event" id="event_<?php echo $eventId ?>">
                        <button class="remove" id="remove_event_<?php echo $eventId ?>" title="remove event">
                            <span class="ui-icon ui-icon-minus wishenda-button"></span>
                        </button>
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
        
        <div id="dialog-confirm" title="Remove the event?">
            <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 2px 2px 0;"></span>
            The event will be permanently deleted and cannot be recovered.</p>
        </div>
        
        <div id="dialog-message" title="Message"></div>
    </body>
</html>
