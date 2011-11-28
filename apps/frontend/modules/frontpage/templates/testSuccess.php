<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<script>
$(document).ready(function()
{
    $('.trigger').ajaxComplete(function() {
        alert('AJAX completed!');
    });

    $('.trigger').ajaxSuccess(function() {
        alert('AJAX succeeded!');
    });

    $('.trigger').ajaxError(function() {
        alert('AJAX failed!');
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
