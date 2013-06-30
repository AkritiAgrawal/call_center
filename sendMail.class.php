<?php
    include "class.phpmailer.php";
    include "class.smtp.php";
    include "class.pop3.php";
    class sendMail  {
            protected $returnId;
            protected $mail;
            protected $send;
            protected $total;
            
         
         /* function for sending mail */
    
    public function mailsend($toEmail,$Body,$subject ) 
    {
        
        $mail  = new PHPMailer();
        $body=$Body;
        $mail->IsSMTP();
        $mail->SMTPAuth   = true;                 
        $mail->SMTPSecure = "ssl";                 
        $mail->Host       = "smtp.gmail.com";      
        $mail->Port       = 465;                  

        $mail->Username   = "agrawalakriti05@gmail.com";  
        $mail->Password   = "LifeIsBeautiful";            

        $mail->From       = "agrawalakriti05@gmail.com";
        $mail->FromName   = "Storybrew Administrator";
        $mail->Subject    = $subject;
        $mail->AltBody    = "This is the body when user views in plain text format"; //Text Body
        $mail->WordWrap   = 50; // set word wrap

        $mail->MsgHTML($body);
       // $mail->AddBCC("saurabhgaur1110@gmail.com");
        //$mail->AddReplyTo("shivam0532@rediffmail.com","shivam ");

        //$mail->AddAttachment("/path/to/file.zip");             // attachment
        //$mail->AddAttachment("/path/to/image.jpg", "new.jpg"); // attachment

        $mail->AddAddress($toEmail,"");

        $mail->IsHTML(true); // send as HTML

        if(!$mail->Send()) 
        {
          echo "Mailer Error: " . $mail->ErrorInfo;
          return false ;
        } 
        else 
        {
            return true;
        }  
         
    }        
  }
?>
