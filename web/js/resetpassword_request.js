$(document).ready(function(){
    $("#reset-password").submit(function(e){
        e.preventDefault();
        var url = $(this).attr('action');            

        $.post( url, {email: $("#email").val()}, function(response){            

            $dataArray = response.split(":"); 

            if($dataArray[0].toLowerCase() == "success")
            {
                alert('Message sent.');
            }
            else
            {
                alert(response);
            }

            window.close();
        });
    });        
});   