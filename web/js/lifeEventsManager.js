$(document).ready(function(){
    
    createEventMenuButtons();
    
    $('#removeLifeEventButton').hide(); // disabled by default
    
    $('.Event').hover(function(){
        onEventHover(this);
    }, function(){
        onEventHoverOut(this);        
    });
    
    $('.remove').hover(function(){
        $(this).addClass('focusEventRemove');
    },function(){
        $(this).removeClass('focusEventRemove');
    });
    
    $('#saveNewEvent').click(onClickSaveAddNewEvent);

    //Don't display My Events if there are no events.
    var myEvents = $('#saved_life_events_div div.flexbox');

    if( myEvents.length <= 0 )
    {
        $('#saved_life_events_div').hide();
    }
    
    $('.remove').button({
        icons: {
            primary: "ui-icon-closethick"
        },
        text: false
    }).click(function(){alert('remove');});
    
    $('.edit').button({
        icons: {
            primary: "ui-icon-pencil"
        },
        text: false
    }).click(function(){alert('edit');}); 
    
    
    $('#newEventPanel').dialog({
        modal: true,
        autoOpen: false,
        title: 'New Event',
        draggable: false,
        resizable: false 
    });
    
});

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

function onClickSaveAddNewEvent(e)
{
    try {
        e.preventDefault();

        if(!validateEventInputs()){
            alert('Invalid inputs');
            return;
        }
    
        // save the new event
        var success = saveNewEvent();
        
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
    
    insertNewEvent();
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

    $('#removeLifeEventButton').button({
            icons: {
                primary: "ui-icon-trash"
            },
            text: false
    });        
}

function onSelectEventHandler(obj)
{
    var selected = $(obj).is(':checked');
    if(selected)
    {
        $('#removeLifeEventButton').show();
    }
    else 
    {
        $('#removeLifeEventButton').hide();
    }
}

var newEventCounter = 0;

function insertNewEvent()
{
    var newEventType = $('#newEventType').val();
    var newEventName = $('#newEventname').val();
    var newImage = newEventType == 1 ? "/images/birthday1.png" : (newEventType == 2 ? "/images/anniversary4.gif" : "other");    
    var dateArr = $('#newDatepicker').val().split('-');
    var dateObj = parseDate(dateArr[1] + "/" + dateArr[2] + "/" + dateArr[0]);
    var day = dateObj.getDay();
    var newEvent = ["<div class='Event'><button class='remove' title='remove event'></button>",
                   ,"<button class='edit' title='edit event'></button>",
                   ,"<div class='image' title='", newEventName, "'><img src='", newImage,"' height='30' width='30' /></div>",
                   ,"<div class='name' title ='", newEventName, "'>", newEventName,"</div>",
                   ,"<div class='timestamp' title='", newEventName, "'>-- ", month[dateObj.getMonth()]," ",day,get_nth_suffix(day),"</div></div>"].join('');
    $('#EventList').prepend(newEvent);
    
    // clear the entries previously input
    $('#newEventname').val('');
    $('#newDatepicker').val('');
    $('#newEventType :selected').removeAttr('selected');
    $('option[value=-1]','#newEventType').attr('selected', 'selected');
}
    