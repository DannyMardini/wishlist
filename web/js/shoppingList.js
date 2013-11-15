
/* Add initialization of other controls here */
$(document).ready(function(){
    $('#shoppingList_bs_table').tablecloth({
          theme: "default",
          striped: true,
          sortable: true,
          bordered: true
    });
    
    createGUIButtons();
    createEventHandlers();
    toggleRetractButton(); // hide or show the 'cancel purchase' button
    updateList(); // displays a special message if the shopping list is empty
    checkCompleted();
});

function checkCompleted()
{
    var expiredPurchases = getExpiredPurchases();
    if(expiredPurchases.length > 0) {
        confirm('Hey, you have wishes you should have fulfilled by now, would you like to remove them from your shopping list?')
        .then(function (answer) {
            if(answer == 1) {
                var url = Routing.generate('WishlistListBundle_completeShoppingListItems');
                ajaxPost({expiredPurchases: expiredPurchases}, url, function(data, textStatus) {
                    if(data.toLowerCase() == 'success') {
                        alert('Success!');
                    }
                    else {
                        alert('Fail!');
                    }
                });
            }
        });
    }
}

function getExpiredPurchases()
{
    var expiredPurchases = [];
    
    $('#expiredPurchases div').each(function(index, element) {
        expiredPurchases.push(element.id);
    });

    return expiredPurchases;
}

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
    $('.selectItem').click(function(e){
        toggleSelectedItem(this);
    });

    
    applyItemHoverHandler($('.shoppinglistItem'));
}

function toggleSelectedItem(obj)
{
    $(obj).toggleClass('selected');
    var chkBox = $('.selectItem', obj);
    chkBox.attr("checked", !chkBox.attr("checked"));
    toggleRetractButton();    
}

// hide the cancel purchases button if there are no more purchases in the list
function toggleRetractButton()
{
    var retractButton = $('#retractPurchaseButton');
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
    var itemsToRemove = $('.selected', '#shoppinglist');
    var rowsToRemove = itemsToRemove.parents('tr'); 
    var selectedPurchaseIds = itemsToRemove.map(function() { return this.id; }).get();
    var purchaseData = { purchaseIds: selectedPurchaseIds};
    ajaxPost(purchaseData, Routing.generate('WishlistListBundle_retractPurchases'), finishRetractPurchaseEvent, rowsToRemove);
}

function finishRetractPurchaseEvent(response, textStatus, jqXHR, rowsToRemove){
    if(response == null) return;
    
    // if an empty string was returned it means that no errors occurred.
    // Remove the canceled items from the list and properly hide 
    // the 'cancel purchase' button if there are zero items left in the list
    if(response.length <= 0){
        
        // remove divs
        rowsToRemove.remove();
        
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
