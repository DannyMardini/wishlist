/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// paramsArray {tags: "cat", tagmode: "any", format: "json"}
function ajaxCall(url, paramsArray, onSuccessMethod, data_type)
{    
    var request = $.ajax({
      url: url,
      type: "POST",
      data: paramsArray,
      dataType: data_type
    });

    request.done(function(data){
        alert(data);
    });

    request.fail(function(jqXHR, textStatus) {
        // send email to danny and andrea here
        alert( "Request failed, please refresh and try again: " + textStatus );      
    });
    
    return;
    
    /*
    $.getJSON(url, paramsArray, function(data) {
          alert(data);
      });
   */
}

//Browser Support Code
function ajaxFunction(queryString){
    var ajaxRequest;  // The variable that makes Ajax possible!

    try
    {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } 
    catch (e)
    {        
        try
        {
            // Internet Explorer Browsers
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } 
        catch (e) 
        {
            try
            {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } 
            catch (e)
            {
                // Something went wrong
                alert("Unable to complete the request.");
                return false;
            }
        }
    }
    
    // Create a function that will receive data sent from the server
    ajaxRequest.onreadystatechange = function(){
            if(ajaxRequest.readyState == 4){
                    //var ajaxDisplay = document.getElementById('ajaxDiv');
                    //ajaxDisplay.innerHTML = ajaxRequest.responseText;
            }
    }
    
    //var queryString = "?age=" + age + "&wpm=" + wpm + "&sex=" + sex;
    ajaxRequest.open("GET", "ajax-example.php" + queryString, true);
    ajaxRequest.send(null); 
}


