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

        $('#submitRequestInvite').click(function() {
            $.post('/frontpage/process', {teststring: 'test'}, function(data){
                alert("Data received from server: " + data);
            });
        });
    });
    </script>

    <form> <!-- Why doesn't this work? -->
    <input type="text" id="email_addr" name="email_addr" autofocus="autofocus" placeholder="Email address" required />
    </form>
    <input type="submit" id="submitRequestInvite" name="submitRequestInvite" value="Request Invite" />

