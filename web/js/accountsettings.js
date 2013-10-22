function saveChanges()
{
    if(allFormsValid()) {
        sendFormValues();
    }
}

function allFormsValid()
{
    Finish checking all the forms!
    if ($('#fullname').val() 
}

function sendFormValues()
{
    var url = $('#accountSettingsForm').attr('action');
    var genderVal = $('input:checked').val();

    $.post( url, {fullname: $('#fullname').val() , email: $("#email_addr").val(), new_password: $('#new_password1').val(), 
                    gender: genderVal},
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
    });


}

$(document).ready(function(){

    $('#saveChanges').click(saveChanges);
    
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
    $('#fullname').val($('#orig_name').val());
    $('#email').val($('#orig_email').val());
    /*    
    $( "#newDatepicker" ).datepicker({
            changeMonth: true,
            changeYear: true
    });
    */

    // add change event handlers
    //$('.trackChanges').keyup(onEditInputEvent);

    // Disable save button
    //disableSaveButton();
});
