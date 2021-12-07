<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../..//PHPMailer/src/Exception.php';
require '../..//PHPMailer/src/PHPMailer.php';
require '../..//PHPMailer/src/SMTP.php';

//Load Composer's autoloader
require '../..//vendor/autoload.php';

require '../connect.php';

if(isset($_POST["email"]))
{
    $email = $_POST["email"];

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'cop4710group29@gmail.com';
        $mail->Password   = 'knights23!';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        //Recipients
        $mail->setFrom('cop4710group29@gmail.com', 'UCF Bookstore');
        $mail->addAddress($email);
        $mail->addReplyTo('no-reply@gmail.com', 'No Reply');

        //Content
        $url = "https://bookstore.brpromedia.com/register";
        $mail->isHTML(true);
        $mail->Subject = 'Join the Digital UCF Bookstore';
        $mail->Body    = '<h1>Welcome to the Digital UCF Bookstore</h1>
                            You are invited to digitally submit your UCF Bookstore orders.
                            Click <a href='.$url.'> HERE </a> to create your account!';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        $array = array("status"=>true);
        echo json_encode($array);
    } catch (Exception $e) {
        $array = array("status"=>false,"message"=>"Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        echo json_encode($array);
    }
}
?>
