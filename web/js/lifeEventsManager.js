$(document).ready(function(){
    
    createEventMenuButtons();
    
    $('#removeLifeEventButton').hide(); // disabled by default
    
    $('#selectall').click(function(){onSelectAllEventHandler(this);});
    
    $('.eventSelect',$('.Event')).click(function(){onSelectEventHandler(this)});
    
    $('#addLifeEventButton').click(addNewEventHandler);

    //Don't display My Events if there are no events.
    var myEvents = $('#saved_life_events_div div.flexbox');

    if( myEvents.length <= 0 )
    {
        $('#saved_life_events_div').hide();
    }
    
});

//function addNewEventHandler(e)
//{
//    e.preventDefault();
//    var eventDateObj = null;
//
//    if(validateEventInputs())
//    {
//        // validate the date
//        try {
//            eventDateObj = parseDate($('#newDatepicker').val());
//            // insert the new event into the My Events section
//            insertNewEvent();
//
//            $('#saved_life_events_div').show();
//        }
//        catch(e)
//        {
//            alert(e)
//        }            
//    }
//    else
//    {
//        alert('invalid inputs');
//    }
//}
    
    
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
    });

    $('#saveLifeEventButton').button({
            icons: {
                primary: "ui-icon-disk"
            },
            text: false
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

function onSelectAllEventHandler(obj)
{
    var selected = $(obj).is(':checked');
    if(selected)
    {
        $('input',$('.Event')).attr('checked','true');
        $('#removeLifeEventButton').show();
    }
    else 
    {
        $('input',$('.Event')).removeAttr('checked');
        $('#removeLifeEventButton').hide();
    }
}

var newEventCounter = 0;

function insertNewEvent()
{
    newEventCounter++;
    var eventId = "newEvent"+newEventCounter;
    var jqueryEventId = "#" + eventId;

    $("<div/>", {
        "class": "flexbox",
        "id": eventId            
    }).appendTo("#saved_life_events_div");

    $('<input />', {
        type: 'text',
        name: 'event_name',
        "value": $('#newEventname').val(),
        "class": "eventname",
        "placeholder": "name"
    }).appendTo(jqueryEventId);

    $('<input />', {
        type: 'text',
        "class": "datepicker",
        "value": $('#newDatepicker').val(),
        "placeholder": "mm/dd/yyyy"
    }).appendTo(jqueryEventId);

    var select = $("<select><option value='-1'>--Type--</option><option value='1'>Birthday</option>" + 
        "<option value='2'>Anniversary</option></select>");
    $('option[value='+ $('#newEventType :selected').val() +']',select).attr('selected', 'selected');
    $(select).appendTo(jqueryEventId);  

    $("<img />", {
        "class": "buttonClass",
        "src": "/images/remove_icon.jpeg", 
        "alt": "Remove this event"
    }).appendTo(jqueryEventId);

    // clear the entries previously input
    $('#newEventname').val('');
    $('#newDatepicker').val('');
    $('#newEventType :selected').removeAttr('selected');
    $('option[value=-1]','#newEventType').attr('selected', 'selected');
}
    