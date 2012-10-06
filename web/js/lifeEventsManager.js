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
    
    //$('#addLifeEventButton').click(addNewEventHandler);
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
    e.preventDefault();
    var eventDateObj = null;

    if(validateEventInputs())
    {
        // validate the date
        try {
            //var dateArr = $('#newDatepicker').val().split('-');
            //var strDate = dateArr[1] + "/" + dateArr[2] + "/" + dateArr[0];
            //eventDateObj = parseDate(strDate);
            // insert the new event into the My Events section
            insertNewEvent();

            $('#newEventPanel').dialog('close');            
        }
        catch(e)
        {
            alert(e)
        }            
    }
    else
    {
        alert('invalid inputs');
    }
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

var newEventCounter = 0;

var month=new Array();
month[0]="January";
month[1]="February";
month[2]="March";
month[3]="April";
month[4]="May";
month[5]="June";
month[6]="July";
month[7]="August";
month[8]="September";
month[9]="October";
month[10]="November";
month[11]="December";

function get_nth_suffix(date) {
  switch (date) {
    case 1:
    case 21:
    case 31:
       return 'st';
    case 2:
    case 22:
       return 'nd';
    case 3:
    case 23:
       return 'rd';
    default:
       return 'th';
  }
}

function insertNewEvent()
{
    var newEventType = $('#newEventType').val();
    var newEventName = $('#newEventname').val();
    var dateArr = $('#newDatepicker').val().split('-');
    var dateObj = parseDate(dateArr[1] + "/" + dateArr[2] + "/" + dateArr[0]);
    var newImage = newEventType == 1 ? "/images/birthday1.png" : (newEventType == 2 ? "/images/anniversary4.gif" : "other");
    var day = dateObj.getDay();
    var newEvent = ["<div class='Event'><button class='remove' title='remove event'></button>",
                   ,"<button class='edit' title='edit event'></button>",
                   ,"<div class='image' title='", newEventName, "'><img src='", newImage,"' height='30' width='30' /></div>",
                   ,"<div class='name' title ='", newEventName, "'>", newEventName,"</div>",
                   ,"<div class='timestamp' title='", newEventName, "'>-- ", month[dateObj.getMonth()]," ",day,get_nth_suffix(day),"</div></div>"].join('');
    $('#EventList').append(newEvent);
    
    // clear the entries previously input
    $('#newEventname').val('');
    $('#newDatepicker').val('');
    $('#newEventType :selected').removeAttr('selected');
    $('option[value=-1]','#newEventType').attr('selected', 'selected');
}
    