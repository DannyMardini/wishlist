
/* Add initialization of other controls here */
$(document).ready(function(){
    createGUIButtons();
    createEventHandlers();
    
    // hide or show the 'cancel purchase' button
    toggleRetractButton();
    
    // displays a special message if the shopping list is empty
    updateList();
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
    });
    
    applyItemHoverHandler($('.shoppinglistItem'));
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

// hide the cancel purchases button if there are no more purchases in the list
function toggleRetractButton()
{
    var retractButton = $('#retractPurchaseButton');
    var purchaseDivs = $('#shoppinglist .shoppinglistitem');            
    purchaseDivs.length <= 0 ? retractButton.hide() : retractButton.show();    
}

function retractPurchaseEvent()
{
    // confirm that this is what the user wants to do
    if(!confirm("Are you sure you want to remove the selected purchases?")) return;
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
        
        // update count
        updateItemCount(selectedPurchaseDivs.length);
        
        // remove divs
        selectedPurchaseDivs.remove();
        updateList();
        
        // update the 'cancel items' button
        toggleRetractButton();
    }
    else { // display the error if any occurred
        alert(response);
    }
}

function updateList()
{
    if($('.shoppinglistitem').length <= 0)
    {
        $('#shoppinglist').html('Your shoppinglist is empty! Browse your friends wishlists to see what they want!');
    }
}

function updateItemCount(itemsRemoved)
{
    var shoppingListHeader = $('.shoppinglist-header-label');
    var currCount = parseInt(shoppingListHeader.attr('id').split('_')[2]);
    var newCount = currCount - itemsRemoved;

    if( newCount < 0 )
    {
        newCount = 0;
    }

    shoppingListHeader
        .attr('id', 'shoppinglist_count_' + newCount)
        .text('Shopping List ( ' + newCount + ' )');
}