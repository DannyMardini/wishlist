$(document).ready(function(){
    
    $('#friendlist ul li').click(function(){
       window.location = $(this).find("a").attr("href");
    });
    
});