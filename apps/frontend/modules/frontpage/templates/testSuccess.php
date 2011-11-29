<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<script>
$(document).ready(function()
{
    $('#submitRequestInvite').ajaxComplete(function() {
        alert('AJAX completed!');
    });

    $('#submitRequestInvite').ajaxSuccess(function() {
        alert('AJAX succeeded!');
    });

    $('#submitRequestInvite').ajaxError(function() {
        alert('AJAX failed!');
    })

    $('#theForm').submit(function(e) {
        e.preventDefault();
        
        $.post('/frontpage/process', {teststring: 'test'}, function(data){
            alert("Data received from server: " + data);
        });
    });
});
</script>

<form id="theForm"> <!-- Why doesn't this work? -->
<input type="email" id="email_addr" name="email_addr" autofocus="autofocus" placeholder="Email address" required />
<input type="submit" id="submitRequestInvite" name="submitRequestInvite" value="Request Invite" />
</form>