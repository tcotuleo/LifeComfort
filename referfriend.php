
<?php 

 $recipients = 'jakeshpatel@gmail.com';

    $headers['From']    = 'rushil.patel92@gmail.com';
    $headers['To']      = 'jakeshpatel@gmail.com';
    $headers['Subject'] = 'Test message';

    $body = 'Test message';

    $smtpinfo["host"] = "smtp.gmail.com";
    $smtpinfo["port"] = "465";
    $smtpinfo["auth"] = true;
    $smtpinfo["username"] = "rushil.patel92";
    $smtpinfo["password"] = "Rushil@1992";


    // Create the mail object using the Mail::factory method
    $mail_object =& Mail::factory("smtp", $smtpinfo); 

    $mail_object->send($recipients, $headers, $body);
//$to = "rushil.patel92@gmail.com"; 
//$subject = "Hi!"; 
//$body = "Hi,\n\nHow are you?"; 
//
//if (mail($to, $subject, $bo dy)) 
//{   
//    echo("<p>Email successfully sent!</p>");  
//    
//} 
//else 
//    {   
//    echo("<p>Email delivery failed…</p>");  
//    
//    } 
    
    ?>
