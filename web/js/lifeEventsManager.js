$(document).ready(function(){
    createEventMenuButtons();
    
    applyEventOnHoverEvent($('.Event'));
    
    $('#saveNewEvent').click(onClickSaveEvent);

    applyRemoveEventButton($('.remove'));
    
    $('#newEventPanel').dialog({
        modal: true,
        autoOpen: false,
        title: 'New Event',
        draggable: false,
        resizable: false 
    });
});

function applyEditEventButton(selector){
    selector.button({
        icons: {
            primary: "ui-icon-pencil"
        },
        text: false
    }).click(function(){alert('edit');}); 
}

function applyRemoveEventButton(selector)
{
    selector.button({
        icons: {
            primary: "ui-icon-closethick"
        },
        text: false
    }).click(onClickRemoveEvent);    
}

function applyEventOnHoverEvent(selector)
{
    $(selector).hover(function(){
        onEventHover(this);
    }, function(){
        onEventHoverOut(this);        
    });    
}

function onClickRemoveEvent(e)
{
    // get the event ID
    var eventId = $(e.target).parent()[0].id.split('_')[2];
    //ajaxCall('/app_dev.php/RemoveEvent', {id:eventId}, removeEventCallback);
}

function removeEventCallback()
{
    alert('Event Removed');
}

function onEventHoverOut(obj)
{
    $(obj).removeClass('focusEvent');
    $('.remove', $(obj)).hide();
    $('.edit',$(obj)).hide();
}

function onEventHover(obj)
{
    $(obj).addClass('focusEvent');
    $('.remove', $(obj)).show(); 
    $('.edit',$(obj)).show();
}

function addNewEventHandler(e)
{
    $('#newEventPanel').show();
}

function onClickSaveEvent(e)
{
    try {
        e.preventDefault();

        if(!validateEventInputs()){
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
    var newDatepicker = $('#newDatepicker').val();
    var newEventType = $('#newEventType option:selected').val();                
    
    ajaxCall('/app_dev.php/SaveEvent', {name: newEventname, date: newDatepicker, type:newEventType}, saveNewEventCallback);  
}

function saveNewEventCallback(data)
{
    // insert the new event into the My Events section
    if(data.toLowerCase().indexOf('issue') > -1){
        alert('The save could not be processed. Contact the wishlist support if the issue persists.');
        return;
    }
    
    insertNewEvent(data);
}
 
function validateEventInputs()
{
    return ($('#newEventname').val() != "" && $('#newDatepicker').val() != ""
    && $("#newEventType option:selected").val()!=-1);
}

function createEventMenuButtons()
{
    $('#addLifeEventButton').button({
            icons: {
                primary: "ui-icon-plusthick"
            },
            text: false
    }).click(function(){
        $('#newEventPanel').dialog('open');
    });      
}

function insertNewEvent(id)
{
    var newEventType = $('#newEventType').val();
    var newEventName = $('#newEventname').val();
    var newImage = newEventType == 1 ? "/images/birthday1.png" : (newEventType == 2 ? "/images/anniversary4.gif" : "/images/otherEvent.jpeg");    
    var dateArr = $('#newDatepicker').val().split('-');
    var dateObj = parseDate(dateArr[1] + "/" + dateArr[2] + "/" + dateArr[0]);
    var day = dateObj.getDay();
    var newEvent = ["<div class='Event' id='event_",id,"'><button id='remove_event_", id, "' class='remove' title='remove event'></button>",
                   ,"<div class='image' title='", newEventName, "'><img src='", newImage,"' height='30' width='30' /></div>",
                   ,"<div class='name' title ='", newEventName, "'>", newEventName,"</div>",
                   ,"<div class='timestamp' title='", newEventName, "'>-- ", month[dateObj.getMonth()]," ",day,get_nth_suffix(day),"</div></div>"].join('');
    $('#EventList').prepend(newEvent);
    
    // clear the entries previously input
    $('#newEventname').val('');
    $('#newDatepicker').val('');
    $('#newEventType :selected').removeAttr('selected');
    $('option[value=-1]','#newEventType').attr('selected', 'selected');
    
    applyRemoveEventButton($('#remove_event_'+id));
    applyEventOnHoverEvent($('#event_'+id));
}
    