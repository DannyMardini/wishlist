<?php $view->extend('::navBar.html.php') ?>
<?php foreach ($view['assetic']->javascripts(array('js/lifeEventsManager.js'), array('?yui_js')) as $url): ?>
<script src="<?php echo $view->escape($url)."?rand=".rand() ?>"></script><?php endforeach; ?>
<?php foreach ($view['assetic']->stylesheets(array('compass/stylesheets/lifeEventsManager.css', 'compass/stylesheets/main.css'), array('?yui_css')) as $url): ?>
<link rel="stylesheet" type="text/css" media="screen, projection" href="<?php echo $view->escape($url)."?rand=".rand() ?>" /><?php endforeach; ?>
<div class="pageTitle">
    <?php $eventCount = count($events); ?>
    <label class="pageHeader" id="event_count_<?php echo $eventCount ?>">Events</label>
    <button class="addButton" title="add event" id="addLifeEventButton"><span class="ui-icon ui-icon-plus wishenda-button"></span></button>
    <span class="itemCountSpan"><span id='eventCount'><?php echo $eventCount ?></span> Event(s)</span>
</div>        
<hr size="1" width="90%" color="grey">
<div id="EventList" class="eventListDiv">
    <?php  
    foreach ($events as $event) {
            $eventId = $event->getId();
            $eventImage = $event->getEventImage();
            $eventName = $event->getName();
            $eventDate = $event->getFormattedTimestamp();
            $timestamp = " -- ".$eventDate;
   ?>  
            <div class="Event" id="event_<?php echo $eventId ?>">
                <button class="remove" id="remove_event_<?php echo $eventId ?>" title="remove event">
                    <span class="ui-icon ui-icon-close wishenda-button"></span>
                </button>
                <div class="image" title="<?php echo $eventName ?>"><img src="<?php echo $eventImage ?>" height="30" width="30" /></div>
                <div class="name" title ="<?php echo $eventName ?>"><?php echo $eventName ?></div>
                <div class="timestamp" title="<?php echo $eventName ?>"><?php echo $timestamp ?></div>
            </div>
   <?php
    }
   ?>            
</div>
<div style="display:none;" id="newEventPanel">            
    <input id="newEventname" type="text" placeholder="Name" required />
    <input id="newEventMonth" type="number" placeholder="M" required /> / <input id="newEventDay" type="number" placeholder="D" required />
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