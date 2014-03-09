
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
    checkCompleted();
});

function checkCompleted()
{
    var expiredPurchases = getIds($('#expiredPurchases div'));
    if(expiredPurchases.length > 0) {
        confirm('Some of your shopping list items have expired. Remember to give your friends their gifts! <br /><br />\n\
                May we remove the expired items from your list?<br /><br />\n\
                To review them first, click No.')
        .then(function (answer) {
            if(answer == 1) {
                var url = Routing.generate('WishlistListBundle_completeShoppingListItems');
                ajaxPost({expiredPurchases: expiredPurchases}, url, function() {
                location.reload();
                });
            }
        });
    }
}

function createGUIButtons(){
    // click event handler for the 'cancel purchase' aka:'retract' button
    $('#retractPurchaseButton').button({
            icons: {
                primary: "ui-icon-minusthick"
            },
            text: false
    }).click(retractPurchaseEvent);
    
    $('#retractPurchaseButton').css('height', '25');
}

function createEventHandlers(){
    $('.selectItem').click(function(e){
        toggleSelectedItem(this);
    });
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
