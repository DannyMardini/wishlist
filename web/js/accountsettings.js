
    function checkPassword(input) {
        if (input.value != document.getElementById('new_password1').value) {
            input.setCustomValidity('The two passwords must match.');
        } 
        else {
            // input is valid -- reset the error message
            input.setCustomValidity('');
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
        
        $( "#datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true
        });
        
        $('#addEventButton').click(addNewEventHandler);
    });
    
    
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
    
    function validateEventInputs()
    {
        return ($('#newEventname').val() != "" && $('#newDatepicker').val() != ""
        && $("#newEventType option:selected").val()!=-1);
    }
    
    function redirectToUserPage()
    {
        window.location = "/app_dev.php/Homepage/";
    }