
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

/* POST: ajax call
 * TO DO: have other ajax call this generic method instead
 * */
function ajaxPost(data, url, onSuccessCallback, callBackParams)
{
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function(response) { 
            if(onSuccessCallback) {
                onSuccessCallback(response, callBackParams);
            }
        }
    });    
}

/*
 * Type can be either 'Event' or 'Date'
 */
function purchaseItem(itemId, purchaseData, /*string*/ type)
{
    if(itemId < 0)
        throw('item is invalid.');
    
    $.ajax({
        type: 'POST',
        url: '/app_dev.php/purchaseItem',
        data: {id: itemId, purchaseData: purchaseData, type: type}
    });
}

function ajaxPageLoad(element, path, itemObj, callback)
{
    $(element).load(path, itemObj, callback);
}

function delFromWishlist(itemObj, callback)
{
    $( "#wishlist" ).load('/app_dev.php/wishlistdelete', itemObj, callback);
}

// paramsObj {tags: "cat", tagmode: "any", format: "json"}
function ajaxCall(url, paramsObj, onSuccessMethod)
{
    $.post(url, paramsObj, function(data) {
        if(onSuccessMethod) {
            onSuccessMethod(data);
        }
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


// ** Date Validation Functions ****************************
function isValidDate(year, month, day)
{
    var daysInMonth = function (y, m) {return 32-new Date(y, m, 32).getDate(); };
    var char_year = year.toString();    
    var d = new Date(); var curr_year = d.getFullYear();

    if(char_year.length != 4 || year > (curr_year+200))
        return false;
    
    if(month < 0 || month > 11)
        return false;
    
    if(day < 0 || day > daysInMonth(year, month))
        return false;
    
    return true;
}

function parseDate(/*string*/ str)
{
    var dtCh = "/";
    var retDate = new Date();
    var pos1=str.indexOf(dtCh);
    var pos2=str.indexOf(dtCh,pos1+1);
    var str_arr = null;
    
    if(str == ""){
        //string is not defined        
        throw "Invalid date.";
    }
    
    if (pos1==-1 || pos2==-1)
    {
        throw "Invalid date.";
    }
    else
    {
        str_arr = str.split("/");
    }
    
    var month = parseInt(str_arr[0], 10);
    var day = parseInt(str_arr[1], 10);
    var year = parseInt(str_arr[2], 10);
    
    //This is quite stupid as monthValue is the only value that begins with an
    //index of zero, subtract one to fix it.
    month--;
    
    if(!isValidDate(year, month, day))
    {
        throw "Invalid date.";
    }
    
    retDate.setFullYear(year, month, day);
    
    return retDate;
}

// ** Date Validation Functions ****************************

function confirm (confirmMessage) {
    var defer = $.Deferred(); 
    $('<div>' + confirmMessage + '</div>').dialog({
            height: 300,
            width: 300,
            modal: true,
            autoOpen: true,
            close: function () { 
                $(this).dialog('destroy');
            },
            title: 'Continue?',
            buttons: {
                "Yes": function() {
                    defer.resolve(1); //on Yes click, end deferred state successfully with 1 value
                    $( this ).dialog( "close" );
                },
                "No": function() {
                    defer.resolve(0); //on No click end deferred successfully with 0 value
                    $( this ).dialog( "close" );
                }
            }
        });
    return defer.promise(); //important to return the deferred promise
}

function popupMessage(theTitle, message)
{    
    $('<div>' + message + '</div>').dialog({
             autoOpen: true,
             close: function () {                  
                 $(this).dialog('destroy');
             },
             title: theTitle,
             buttons: {
                 "Ok": function() {                     
                     $( this ).dialog( "close" );
                 }
             }
         });    
}
