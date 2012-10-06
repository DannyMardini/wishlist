function printStats(element)
{
    console.log(element.attr('id')+": "+element.height()+" "+element.innerHeight()+" "+element.outerHeight());
}

$(document).ready(function(){
    printStats($('#parent'));
    printStats($('#child'));
});
