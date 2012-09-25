$(document).ready(function(){
    
    $('#addLifeEventButton').button({
            icons: {
                primary: "ui-icon-plusthick"
            },
            text: false
    });
    
    $('#removeLifeEventButton').button({
            icons: {
                primary: "ui-icon-trash"
            },
            text: false
    });
    
    $('#removeLifeEventButton').attr('disabled', 'disabled'); // disabled by default
    
    $('#saveLifeEventButton').button({
            icons: {
                primary: "ui-icon-disk"
            },
            text: false
    });
    
    $('.Event input:checkbox').click(function(){
        
        // check if any checkboxes are selected
        var arrChecked = $('input:checked',$('.Event'));
        if(arrChecked.length > 0)
        {
            $('#removeLifeEventButton').removeAttr('disabled');
        }
        else
        {
            $('#removeLifeEventButton').attr('disabled', 'disabled');
        }
    });
    
});