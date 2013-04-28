
/* Add initialization of other controls here */
$(document).ready(function(){
    createGUIButtons();
    createEventHandlers();
    toggleRetractButton(); // hide or show the 'cancel purchase' button
    updateList(); // displays a special message if the shopping list is empty
});

function createGUIButtons(){
    // click event handler for the 'cancel purchase' aka:'retract' button
    $('#retractPurchaseButton').button({
            icons: {
                primary: "ui-icon-minusthick"
            },
            text: false
    }).click(retractPurchaseEvent);
}

function createEventHandlers(){
    // click event handler for the purchase items
    $('.shoppinglistItem').click(function(){
        $(this).toggleClass('selected');
        var chkBox = $('.selectItem', this);
        chkBox.attr("checked", !chkBox.attr("checked"));
        toggleRetractButton();
    });
    
    applyItemHoverHandler($('.shoppinglistItem'));
}

// hide the cancel purchases button if there are no more purchases in the list
function toggleRetractButton()
{
    var retractButton = $('#retractPurchaseButton');
    //var purchaseDivs = $('#shoppinglist .shoppinglistitem');
    var selectedDivs = $('#shoppinglist .selected');
    selectedDivs.length <= 0 ? retractButton.hide() : retractButton.show();    
}

function updateList()
{
    if($('.shoppinglistitem').length <= 0)
    {
        $('#shoppinglist').html('Your shoppinglist is empty! Browse your friends wishlists to see what they want!');
    }
}

function applyItemHoverHandler(selector){
    $(selector).hover(function(){
        onEventHoverHandler(this);
    }, function(){
        onEventHoverOutHandler(this);        
    });    
}

function onEventHoverOutHandler(obj)
{
    $(obj).removeClass('focusPurchase');
}

function onEventHoverHandler(obj)
{
    $(obj).addClass('focusPurchase');
}

function retractPurchaseEvent()
{
    // confirm that this is what the user wants to do
    confirm('Are you sure you want to remove the selected purchases?')
    .then(function (answer) {//then will run if 1 (Yes) or 0 (No) is clicked
        if(answer == 1) // 1 means continue
        {
            continueRemovingItems();
        }
    });
}

function continueRemovingItems()
{
    var selectedPurchaseDivs = $('.selected','#shoppinglist'); 
    var selectedPurchaseIds = selectedPurchaseDivs.map(function() { return this.id; }).get();
    var purchaseData = { purchaseIds: selectedPurchaseIds};
    ajaxPost(purchaseData, '/app_dev.php/retractPurchases', finishRetractPurchaseEvent, selectedPurchaseDivs);    
}

function finishRetractPurchaseEvent(response, selectedPurchaseDivs){
    if(response == null) return;
    
    // if an empty string was returned it means that no errors occurred.
    // Remove the canceled items from the list and properly hide 
    // the 'cancel purchase' button if there are zero items left in the list
    if(response.length <= 0){
        
        // remove divs
        selectedPurchaseDivs.remove();
        
        // update count
        updateItemCount();
        
        updateList();
        
        // update the 'cancel items' button
        toggleRetractButton();
    }
    else { // display the error if any occurred        
        popupMessage('An Issue Occurred!','<p>'+response+'</p>');
    }
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

function updateItemCount()
{
    var newCount = $('#shoppinglist .shoppinglistitem').length; 

    if( newCount < 0 )
    {
        newCount = 0;
    }

    $('.shoppinglist-header-label')
        .attr('id', 'shoppinglist_count_' + newCount)
        .text('Shopping List ( ' + newCount + ' )');
}

function confirm (confirmMessage) {
    var defer = $.Deferred(); 
    $('<div>' + confirmMessage + '</div>').dialog({
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