function purchaseItem(itemId, eventId)
{
    if((itemId < 0) || (eventId < 0))
        throw('item or event id is invalid');
    
    $.ajax({
        type: 'POST',
        url: '/app_dev.php/purchaseItem',
        data: {id: itemId, eventId: eventId}
    })
    .done(function() {alert("success!")})
    .fail(function() {alert("Failure!")});
}

function addToWishlist(itemObj, callback)
{    
    $( "#wishlist" ).load('/app_dev.php/wishlistnew', itemObj, callback); 
}

function delFromWishlist(itemObj, callback)
{
    $( "#wishlist" ).load('/app_dev.php/wishlistdelete', itemObj, callback);
}


function fillContainer(element)
{
    //$(element).get
}

// paramsArray {tags: "cat", tagmode: "any", format: "json"}
function ajaxCall(url, paramsArray, onSuccessMethod, data_type)
{    
    $.post(url, paramsArray, function(data) {
        alert("hullo");
    });
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



