<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<script>
$(document).ready(function()
{
    $('.log').ajaxComplete(function() {
        alert('AJAX completed!');
    });

    $('.log').ajaxSuccess(function() {
        alert('AJAX succeeded!');
    });

    $('.log').ajaxError(function() {
        alaert('AJAX failed!');
    })

    $('.trigger').click(function() {
        $.post('/frontpage/process', {lovestring: "I love you bapper"}, function(data){
            alert("Data received from server: " + data);
        });
    });
});
</script>

<div class="trigger">Trigger</div>
<div class="result"></div>
<div class="log"></div>
