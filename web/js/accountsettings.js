var changes = {};
changes.count = 0;
window.onbeforeunload = promptConfirmation;

    function pushChange(elementId, newValue)
    {
        var key = elementId.toString();
        var orig_value = $("#orig_"+key).val();
        
        // check if the new value equals the original value
        if(newValue == orig_value)
        {
            popChange(key);
            return;
        }
        
        if(!changes.hasOwnProperty(key))
        {
            changes.count++;
        }
        
        changes[key] = newValue;
    }
    
    function popChange(key)
    {
        delete changes[key];
        changes.count--;
    }
    
    function checkPassword(input) {
        if (input.value != document.getElementById('new_password1').value) {
            input.setCustomValidity('The two passwords must match.');
        } 
        else {
            // input is valid -- reset the error message
            input.setCustomValidity('');
        }
    }    
    
    function promptConfirmation()
    {
        if(changes.count > 0){
            return "You have unsaved changes";
        }
    }

    $(document).ready(function(){
        
        $('#saveChanges').click(function(){
            var url = $('#accountSettingsForm').attr('action');
            
            $.post( url, {fullname: $('#full_name').val() , email: $("#email_addr").val(), 
                old_password: $("#old_password").val(), new_password: $('#new_password1').val()},
                function(response){
                    $dataArray = response.split(":"); 
                    if($dataArray[0].toLowerCase() == "success")
                    {
                        alert('Message sent.');
                    }
                    else
                    {
                        alert(response);
                    }

                    redirectToQAHome();
            });
        });
        
        $('#photoimg').live('change', function()	
        { 
            $("#preview").html('');
            $("#preview").html('<img src="/images/loader.gif" alt="Uploading...."/>');
            
            $("#imageform").ajaxForm(
            {
                target: '#preview'
            }).submit();    
        });     
               
        var gender = $('#orig_gender').val();
        $('#gender_'+gender).attr('checked',true);
        $('#firstName').val($('#orig_firstName').val());
        $('#lastName').val($('#orig_lastName').val());
        $('#email').val($('#orig_email').val());
        
        $( "#newDatepicker" ).datepicker({
                changeMonth: true,
                changeYear: true
        });
        
        /*
        $('#addEventButton').click(addNewEventHandler);
        
        //Don't display My Events if there are no events.
        var myEvents = $('#saved_life_events_div div.flexbox');
        
        if( myEvents.length <= 0 )
        {
            $('#saved_life_events_div').hide();
        }
        */
       
        // add change event handlers
        $('.trackChanges').keyup(onEditInputEvent);
        
        // Disable save button
        disableSaveButton();
    });
    
    function disableSaveButton()
    {
        $('#saveChanges').attr('disabled', 'true');
        $('#saveChanges').addClass('disabledButton');
    }
    
    function enableSaveButton()
    {
        $('#saveChanges').removeAttr('disabled').removeClass('disabledButton');
        $('#saveChanges').addClass('enabledButton');
    }
    
    function toggleSaveButton()
    {
        if(changes.count > 0)
        {
            enableSaveButton();
        }else
        {
            disableSaveButton();
        }
    }
    
    function onEditInputEvent()
    {
        pushChange($(this).attr('id'), $(this).val());
        toggleSaveButton();
    }
    
    function addNewEventHandler(e)
    {
        e.preventDefault();
        var eventDateObj = null;
        
        if(validateEventInputs())
        {
            // validate the date
            try {
                eventDateObj = parseDate($('#newDatepicker').val());
                // insert the new event into the My Events section
                insertNewEvent();
                
                $('#saved_life_events_div').show();
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
    
    /*
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
    */
   
    function validateEventInputs()
    {
        return ($('#newEventname').val() != "" && $('#newDatepicker').val() != ""
        && $("#newEventType option:selected").val()!=-1);
    }
    
    function redirectToUserPage()
    {
        window.location = "/app_dev.php/Homepage/";
    }