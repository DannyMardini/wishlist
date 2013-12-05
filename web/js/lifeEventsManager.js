var selectedEventId = null;
var eventListEmptyMessage = '<p class="message">You don\'t have any events! To add an event click the (+) button above!<br/><br />Event examples: your birthday, an anniversary, christmas, etc</p>';
var couldNotRemoveEventMessage = 'Event could not be removed. Contact the Wishlist support if the issue persists.';
var couldNotSaveEventMessage = 'The save could not be processed. Contact the wishlist support if the issue persists.';

$(document).ready(function(){
    createGUIButtons();
    createGUIDialogs();
    setupEventHandlers();
    checkIfEmptyMessageRequired();
});

function setupEventHandlers()
{
    applyEventHoverHandler($('.Event'));
    $('#saveNewEvent').click(onClickSaveEventHandler);    
}

function createGUIButtons()
{
    $('#addLifeEventButton').button({
            icons: { primary: "ui-icon-plusthick" },
            text: false
    }).click(function(){
        clearNewEventPanel();
        $('#newEventPanel').dialog('open');
    });
    
    setupRemoveEventButtons($('.remove'));
}

function clearNewEventPanel()
{
    $('#newEventname').val('');
    $('#newEventMonth').val('');
    $('#newEventDay').val('');
    $('#newEventType').val('-1');
}

function createGUIDialogs()
{
   $('#newEventPanel').dialog({
       position: 'top',
        modal: true,
        autoOpen: false,
        title: 'New Event',
        draggable: false,
        resizable: false 
    });
    
    $('#dialog-message').dialog({
        position: 'top',
        autoOpen: false,
        resizable: false,
        height:230,
        modal:true,
        buttons: {
            "Ok": function(){
                $( this ).dialog( "close" );
            }
        }
    });
    
    $( "#dialog-confirm" ).dialog({
        position: 'top',
        autoOpen: false,
        resizable: false,
        height:230,
        modal: true,
        buttons: {
            "Continue": function() {                
                removeEvent();
                $( this ).dialog( "close" );
            },
            Cancel: function() {
                $( this ).dialog( "close" );
            }
        }
    });    
}

function setupRemoveEventButtons(selector)
{
    selector.button({
        icons: {
            primary: "ui-icon-closethick"
        },
        text: false
    }).click(onClickRemoveEventHandler); 
}

function applyEventHoverHandler(selector)
{
    $(selector).hover(function(){
        onEventHoverHandler(this);
    }, function(){
        onEventHoverOutHandler(this);        
    });    
}

function onEventHoverOutHandler(obj)
{
    $(obj).removeClass('focusEvent');
    $('.remove', $(obj)).hide();
    $('.edit',$(obj)).hide();
}

function onEventHoverHandler(obj)
{
    $(obj).addClass('focusEvent');
    $('.remove', $(obj)).show(); 
    $('.edit',$(obj)).show();
}

function onClickRemoveEventHandler(e)
{   
    // get the event ID
    selectedEventId = $(e.target).parent()[0].id.split('_')[2];
    
    // confirm deletion before continuing
    $('#dialog-confirm').dialog('open');
}

function removeEvent()
{
    if(!selectedEventId)
    {
        $('#dialog-message').attr('title','An issue occurred!').html('<p>'+couldNotRemoveEventMessage+'</p>').dialog('open');
    }
    
    ajaxCall(Routing.generate('WishlistUserBundle_removeEvent'), {id:selectedEventId}, removeEventCallback);
}

function checkIfEmptyMessageRequired()
{
    var eventCount = getEventCount();
    if(eventCount == 0)
    {
        $('#EventList').html(eventListEmptyMessage);
    }
}

function removeEventCallback(response)
{
    if(response == '0')
    {        
        $('#dialog-message').attr('title','An issue occurred!').html('<p>'+couldNotRemoveEventMessage+'</p>').dialog('open');
        return;
    }
    
    // remove the event from the table view.
    $('#event_'+response).remove();
    checkIfEmptyMessageRequired();
    updateEventCountSpan();
    $('#dialog-message').dialog('option', 'title', 'Event Removed!');
    $('#dialog-message').dialog('open');
    $('#dialog-message').html('<p>The event was permanently removed.</p>');
    
    selectedEventId = null;
}

function onClickSaveEventHandler(e)
{
    try {
        e.preventDefault();

        if(!validateNewEventInputs()){
            alert('Invalid inputs');
            return;
        }
    
        // save the new event
        saveNewEvent();
        
        $('#newEventPanel').dialog('close');
    }
    catch(e)
    {
        alert(e)
    }        
}
    
function saveNewEvent()
{
    var newEventname = $('#newEventname').val();
    var newEventMonth = $('#newEventMonth').val();
    var newEventDay = $('#newEventDay').val();
    var newEventType = $('#newEventType option:selected').val();                
    
    ajaxPost({name: newEventname, month: newEventMonth, day: newEventDay, type:newEventType}, Routing.generate('WishlistUserBundle_saveEvent'), saveNewEventCallback);
}

function saveNewEventCallback(data)
{
    try
    {
        // insert the new event into the My Events section
        if(data.toLowerCase().indexOf('issue') > -1){
            throw couldNotSaveEventMessage;
        }
    
        renderNewEvent(data);
    
        updateEventCountSpan();
    
        $('#dialog-message').attr('title','Event saved!').html('<p>The event was saved.</p>').dialog('open');
    }
    catch(e)
    {
        $('#dialog-message').attr('title','An issue occurred!').html('<p>'+e+'</p>').dialog('open');
    }
}
 
function validateNewEventInputs()
{
    return ($('#newEventname').val() != "" && $('#newDatepicker').val() != ""
    && $("#newEventType option:selected").val()!=-1);
}

function getEventCount()
{
    return $('div.Event').length;
}

function updateEventCountSpan()
{
    $('#eventCount').html(getEventCount());
}

function renderNewEvent(id)
{
    var eventCount = getEventCount();
    if(eventCount==0) { //Clear out "You haven't added any events yet." message
        $('#EventList').html('');
    }   
    
    var newEventType = $('#newEventType').val();
    var newEventName = $('#newEventname').val();
    var newImage = newEventType == 1 ? "/images/birthday1.png" : (newEventType == 2 ? "/images/anniversary4.gif" : "/images/otherEvent.jpeg");    
    var eventMonth = $('#newEventMonth').val();
    var eventDay = $('#newEventDay').val();
    var dateObj = parseDate(eventMonth + "/" + eventDay + "/" + 2004); // the year is hard coded it's just a dummy year, because the year isn't being tracked anyway
    var day = dateObj.getDate();
    var newEvent = ["<div class='Event' id='event_",id,"'><button id='remove_event_", id, "' class='remove' title='remove event'><span class='ui-icon ui-icon-minus wishenda-button'></span></button>",
                   ,"<div class='image' title='", newEventName, "'><img src='", newImage,"' height='30' width='30' /></div>",
                   ,"<div class='name' title ='", newEventName, "'>", newEventName,"</div>",
                   ,"<div class='timestamp' title='", newEventName, "'>-- ", month[dateObj.getMonth()]," ",day,get_nth_suffix(day),"</div></div>"].join('');
    $('#EventList').prepend(newEvent);
    
    // clear the entries previously input
    $('#newEventname').val('');
    $('#newDatepicker').val('');
    $('#newEventType :selected').removeAttr('selected');
    $('option[value=-1]','#newEventType').attr('selected', 'selected');
    
    setupRemoveEventButtons($('#remove_event_'+id));
    applyEventHoverHandler($('#event_'+id));
}

