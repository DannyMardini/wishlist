<form id="contactSupportForm" method="POST" action="<?php echo $view['router']->generate('WishlistQABundle_help') ?>">

<!--  <label>Regarding:</label>
  <select>
  <option value>-</option>
  <option value="deactivate_activate_account">Deactivate/Activate account</option>
  <option value="report_attack">Report attack</option>
  <option value="missing_data">My wishlist information is missing</option>
  <option value="something_else">My issue is not in this list</option>
  </select>-->
  <input type="hidden" id="subject" value="Support Contacted -Needs Attention"
  
  <label>Full name:</label>
  <input type="text" id="full_name" name="full_name" placeholder="Jane Doe" required>

  <label>Email address:</label>
  <input type="email" id="email_addr" name="email_addr" required>

  <label>Repeat email address:</label>
  <input type="email" id="email_addr_repeat" name="email_addr_repeat" required 
   oninput="check(this)">

  <label>Message:</label>
  <textarea id="message" rows="5" required></textarea>

  <input type="submit" value="Send" /> 
</form>

<script>
    function check(input) {
        if (input.value != document.getElementById('email_addr').value) {
            input.setCustomValidity('The two email addresses must match.');
        } 
        else {
            // input is valid -- reset the error message
            input.setCustomValidity('');
        }
    }

    $(document).ready(function(){
        $("#contactSupportForm").submit(function(e){
            e.preventDefault();
            var url = $(this).attr('action');
            var encoded_message = escape($("#message").val());

            $.post( url, {subject: $('#subject').val() , fullname: $("#full_name").val(), email: $("#email_addr").val(), message: encoded_message}, function(response){            

                $dataArray = response.split(":"); 

                if($dataArray[0].toLowerCase() == "success")
                {
                    alert('Message sent.');
                }
                else
                {
                    alert(response);
                }
                
                redirectToQAHome();
            });
        });        
    });
    
    
    function redirectToQAHome()
    {
        window.location = Routing.generate('WishlistQABundle_help');
    }
    
    
</script>
