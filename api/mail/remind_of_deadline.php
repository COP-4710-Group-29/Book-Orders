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

    $sql = "SELECT deadline FROM deadlines LIMIT 1";
    $stmt = $pdo->prepare($sql);

    // Execute
    $result = $stmt->execute();

    // If the execution failed, throw an error
    if(!$result)
    {
      $array = array("status"=>false,"message"=>"We could not load the page. Please try again.");
    	echo json_encode($array);
      die();
    }

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch the result
    $deadline = $row['deadline'];

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
        $url = "https://bookstore.brpromedia.com/orders/create";
        $mail->isHTML(true);
        $mail->Subject = 'UCF Bookstore Order is Due Soon';
        $mail->Body    = '<h1>Your UCF Bookstore Order is Due Soon</h1>
                            If you have not already submitted your bookstore,
                            you can click <a href='.$url.'> HERE </a> to submit it!
                            <br>
                            You have until <strong>'.$deadline.'</strong> to submit your order.
                            <br>
                            If you have already submitted your order, please ignore this email.';
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
