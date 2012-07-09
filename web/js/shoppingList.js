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

$(document).ready(function(){
    setupPage();
});