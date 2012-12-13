function setupPage()
{
    $('#div_shoppinglist_div table tr td input').click(function(){
        var row = $(this).parents('tr')
        
        if(row.hasClass('selected')){
            row.removeClass('selected');
        }else{
            row.addClass('selected');
        }
    });
}

function retractPurchaseEvent()
{
    var selectedPurchases = $('.selected','#div_shoppinglist_div table');
    var retractedPurchases = new Array();
    for(var p = 0; p < selectedPurchases.length; p++)
    {
        retractedPurchases.push(selectedPurchases[p].id);
    }
    
    selectedPurchases.remove();
    
    $.ajax({
        type: 'POST',
        url: '/app_dev.php/retractPurchases',
        data: {purchaseIds: retractedPurchases}
    });
}

$(document).ready(function(){
    setupPage();
    $('#retractPurchaseButton').click(retractPurchaseEvent);
});