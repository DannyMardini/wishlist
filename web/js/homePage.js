/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    
   $("#linkList").menu();
   $("#mainProfileLink").removeClass("ui-menu-item");
//   $("#mainProfileLink").hover(
//     function() {$("#linkList li").show();}, 
//     function() {showOnlyMainProfileLink();}
//   );
   
//   $("#profileLinks, #linkList,#linkList li a").hover(
//     function() {$("#linkList li").show();}, 
//     function() {showOnlyMainProfileLink();}
//   );
       
       $("a").click(function(){
		$(this).blur();
	});
	
	//When mouse rolls over
	$("li").mouseover(function(){
		$(this).stop().animate({height:'150px'},{queue:false, duration:600, easing: 'easeOutBounce'})
	});
	
	//When mouse is removed
	$("li").mouseout(function(){
		$(this).stop().animate({height:'50px'},{queue:false, duration:600, easing: 'easeOutBounce'})
	});
	
   
    //showOnlyMainProfileLink();
});

function showOnlyMainProfileLink()
{
   $("#linkList li").hide();
   $("#mainProfileLink").show();    
}
