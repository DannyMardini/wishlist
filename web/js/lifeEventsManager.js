$(document).ready(function(){
    
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
    
    $('#removeLifeEventButton').hide(); // disabled by default
    
    $('#selectall').click(function(){
       var selected = $(this).is(':checked');
       if(selected)
        {
            $('input',$('.Event')).attr('checked','true');
        }
        else 
        {
            $('input',$('.Event')).removeAttr('checked');
        }
    });
    
    $('.Event input:checkbox').click(function(){
        // check if any checkboxes are selected
        var arrChecked = $('input:checked',$('.Event'));
        if(arrChecked.length > 0)
        {
            $('#removeLifeEventButton').show();
        }
        else
        {
            $('#removeLifeEventButton').hide();
        }    
    })
    
});